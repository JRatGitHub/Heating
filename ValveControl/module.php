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
		}

		public function MeineErsteEigeneFunktion() {
			IPS_LogMessage('Valve Control', 'Valve Control mijn fun');
            echo $this->InstanceID;
		}
		
		public function ValveOn()
		{
			//$ValveID = $this->ReadPropertyInteger('ValveID');
			//IPS_LogMessage('Heating', $ValveID ."\n"); 
			echo  "Hallo Wereld.";

		}
	}
