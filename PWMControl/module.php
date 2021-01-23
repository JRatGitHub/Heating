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

			 //Variables
			 $PWMSetpoint = $this->RegisterVariableInteger('PWMSetpoint', 'Setpoint', '~Intensity.100',0);
			 $PWMOutput = $this->RegisterVariableBoolean('PWMOutput', 'Output');

			 //Timers
			$this->RegisterTimer('OpenTimer', 0, "VALVE_CalculatePWM(\$_IPS['TARGET']);");
			$this->RegisterTimer('ClosedTimer', 0, "VALVE_CalculatePWM(\$_IPS['TARGET']);");
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
		}

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
		//	IPS_LogMessage("PWMControl", "Message from SenderID ".$SenderID." with Message ".$Message."\r\n Data: ".print_r($Data, true));
			if ($Message == VM_UPDATE) {
				//IPS_LogMessage("PWMControl:MessageSink", "Updated");
				if ($SenderID == $this->GetIDForIdent('PWMSetpoint')){
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint Updated");
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint old value:".$Data[2] ." %");
					IPS_LogMessage("PWMControl:MessageSink", "PWMSetpoint new value:".$Data[0] ." %");


				}

			}
		}


		protected function CalculatePWM($Setpoint){
			IPS_LogMessage("PWMControl", "CalculatePWM triggered with setpoint: ".$Setpoint);
		}
		protected function SetPWM($Setpoint){
			IPS_LogMessage("PWMControl", "SetPWM triggered with setpoint: ".$Setpoint);
			$duration = $this->ReadPropertyInteger('CycleTime') * $Setpoint;
			IPS_LogMessage("PWMControl", "SetPWM duration: ".$duration . "Sec.");
			//$this->SetTimerInterval('OpenTimer', $duration * 1000);

		}
	}