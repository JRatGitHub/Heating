<?php
	class ValveControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			//$this->RegisterPropertyString('Mac', '');
			//$this->RegisterPropertyInteger('ScanInterval', 60);
			$this->RegisterPropertyInteger('ValveOpenDelay',60);
			$this->RegisterPropertyInteger('ValveCloseDelay',60);
			$this->RegisterPropertyInteger('Seconds',10);
			$this->RegisterPropertyInteger('ValveID', 0);

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

			$HeatRequestID = $this->RegisterVariableBoolean('HeatRequest', 'Heat Request');
			$ValveID= $this->RegisterVariableBoolean('ValveStatus', 'Valve');
			$StatusID = $this->RegisterVariableString('Status', 'Status', '', 2);
		}


		public function MeineErsteEigeneFunktion() {
			//IPS_LogMessage('Valve Control', 'Valve Control mijn fun');
            echo $this->InstanceID;
		}
		
		public function ValveOff()
		{
			//$ValveID = $this->ReadPropertyInteger('ValveID');
			//IPS_LogMessage('Heating', $ValveID ."\n");
			
			HM_WriteValueBoolean($this->ReadPropertyInteger('ValveID'),'STATE',False);
		}

		public function ValveOn()
		{
			//$ValveID = $this->ReadPropertyInteger('ValveID');
			//IPS_LogMessage('Heating', $ValveId ."\n"); 
			HM_WriteValueBoolean($this->ReadPropertyInteger('ValveID'),'STATE',True);
		}

		public function Scan()
		{
			$ValveLink = $this->ReadPropertyInteger('ValveID');
			echo $ValveLink;
			IPS_LogMessage('ValveDevice', 'Hello Semaphore in Scan');

	
		}	
	}
