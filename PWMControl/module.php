<?php
	class PWMControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			 //Properties
			 $this->RegisterPropertyInteger('CycleTime', 1500);
			 $this->RegisterPropertyInteger('PWMsetpointID', 0);
			 $this->RegisterPropertyInteger('ValveID', 0);

			 $this->RegisterPropertyInteger('UpdateInterval', 10);
			 //$this->RegisterPropertyBoolean('ResendAction', false);
			 $this->RegisterPropertyBoolean('DisplayRemaining', false);

			 //Variables
			 $PWMSetpoint = $this->RegisterVariableInteger('PWMSetpoint', 'Setpoint', '~Intensity.100',0);
			 $PWMOutput = $this->RegisterVariableBoolean('PWMOutput', 'Output');



			 //Timers
			$this->RegisterTimer('OpenTimer', 0, "PWM_OpenTimeEnded(\$_IPS['TARGET']);");
			$this->RegisterTimer('ClosedTimer', 0, "PWM_ClosedTimeEnded(\$_IPS['TARGET']);");
			$this->RegisterTimer('UpdateRemainingTimer', 0, "PWM_UpdateRemaining(\$_IPS['TARGET']);");

			//intialize
			SetValueBoolean($this->GetIDForIdent('PWMOutput'),False);
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();

			$this->RegisterMessage($this->GetIDForIdent('PWMSetpoint'), VM_UPDATE);
			$this->RegisterReference($this->GetIDForIdent('PWMSetpoint')); 

			//Register variable if enabled
			$this->MaintainVariable('Remaining', 'Remaining time', VARIABLETYPE_STRING, '', 10, $this->ReadPropertyBoolean('DisplayRemaining'));
		}

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
		//	IPS_LogMessage("PWMControl", "Message from SenderID ".$SenderID." with Message ".$Message."\r\n Data: ".print_r($Data, true));
			if ($Message == VM_UPDATE) {
				//IPS_LogMessage("PWMControl:MessageSink", "Updated");
				if ($SenderID == $this->GetIDForIdent('PWMSetpoint')){
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint Updated");
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint old value:".$Data[2] ." %");
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint new value:".$Data[0] ." %");
					$result = $this->SetPWM($Data[0]);
				}
			}
		}

		public function OpenTimeEnded(){
			IPS_LogMessage("PWMControl", "OpenTimeEnded triggered.");
			$this->SetTimerInterval('OpenTimer',0);
			SetValueBoolean($this->GetIDForIdent('PWMOutput'),False);
			$Setpoint = GetValueInteger($this->GetIDForIdent('PWMSetpoint'));
			$duration = ($this->ReadPropertyInteger('CycleTime')/100) * (100-$Setpoint);
			IPS_LogMessage("PWMControl", "SetPWM duration: ".$duration . " Sec.");
			$this->SetTimerInterval('ClosedTimer', $duration * 1000);
		}

		public function ClosedTimeEnded(){
			IPS_LogMessage("PWMControl", "ClosedTimeEnded triggered.");
			$this->SetTimerInterval('ClosedTimer',0);
			SetValueBoolean($this->GetIDForIdent('PWMOutput'),True);
			$Setpoint = GetValueInteger($this->GetIDForIdent('PWMSetpoint'));
			$duration = ($this->ReadPropertyInteger('CycleTime')/100) * $Setpoint;
			IPS_LogMessage("PWMControl", "SetPWM duration: ".$duration . " Sec.");
			$this->SetTimerInterval('OpenTimer', $duration * 1000);
		}


		protected function CalculatePWM($Setpoint){
			IPS_LogMessage("PWMControl", "CalculatePWM triggered with setpoint: ".$Setpoint);
		}
		
		protected function SetPWM($Setpoint){
			IPS_LogMessage("PWMControl", "SetPWM triggered with setpoint: ".$Setpoint);
			$duration = ($this->ReadPropertyInteger('CycleTime')/100) * $Setpoint;
			IPS_LogMessage("PWMControl", "SetPWM duration: ".$duration . " Sec.");
			// Switch the output to false
			SetValueBoolean($this->GetIDForIdent('PWMOutput'),False);
			
			//$this->SetTimerInterval('OpenTimer', $duration * 1000);
			//SetValueBoolean($this->GetIDForIdent('PWMOutput'),True);
			if($duration<=0){
				IPS_LogMessage("PWMControl", "SetPWM duration: ".$duration . " Sec. and output set to false");
				SetValueBoolean($this->GetIDForIdent('PWMOutput'),False);
				$this->SetTimerInterval('OpenTimer', 0);
				$this->SetTimerInterval('ClosedTimer',0);
			} else {
				$this->SetTimerInterval('ClosedTimer',0);
				$this->SetTimerInterval('OpenTimer', $duration * 1000);
				SetValueBoolean($this->GetIDForIdent('PWMOutput'),True);
				
				//Update display variable periodically if enabled
				if ($this->ReadPropertyBoolean('DisplayRemaining')) {
					$this->SetTimerInterval('UpdateRemainingTimer', 1000 * $this->ReadPropertyInteger('UpdateInterval'));
					$this->UpdateRemaining();
				}
			}


		}

		public function UpdateRemaining(){
        	$secondsRemaining = 0;
        	foreach (IPS_GetTimerList() as $timerID) {
            	$timer = IPS_GetTimer($timerID);
            	if (($timer['InstanceID'] == $this->InstanceID) && ($timer['Name'] == 'OpenTimer')) {
                	$secondsRemaining = $timer['NextRun'] - time();
                	break;
            	}
        	}
        	//Display remaining time as string
        	$this->SetValue('Remaining', sprintf('%02d:%02d:%02d', ($secondsRemaining / 3600), ($secondsRemaining / 60 % 60), $secondsRemaining % 60));
    	}

		public function ToggleDisplayInterval($visible)
		{
			$this->UpdateFormField('UpdateInterval', 'visible', $visible);
		}
	}