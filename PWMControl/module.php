<?php
	class PWMControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			 //Properties
			 $this->RegisterPropertyInteger('CycleTime', 150);
			 $this->RegisterPropertyInteger('PWMsetpointID', 0);
			 $this->RegisterPropertyInteger('ValveID', 0);

			 //Variables
			 $PWMSetpoint = $this->RegisterVariableInteger('PWMSetpoint', 'PWM Setpoint', '~Intensity.100',0);
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

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data) 
		{
			IPS_LogMessage("PWMControl", "Message from SenderID ".$SenderID." with Message ".$Message."\r\n Data: ".print_r($Data, true));
			if ($Message == VM_UPDATE) {
				IPS_LogMessage("MessageSink", "Updated");
			}
		}

		protected function SetPWM($Setpoint){
			IPS_LogMessage("PWMControl", "SetPWM triggered with setpoint: ".$Setpoint);
		}
	}