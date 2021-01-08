<?php
	class ValveControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			 //Properties
			$this->RegisterPropertyInteger('ValveOpenDelay',60);
			$this->RegisterPropertyInteger('ValveCloseDelay',60);
			$this->RegisterPropertyInteger('Seconds',10);
			$this->RegisterPropertyInteger('ValveID', 0);
			$this->RegisterPropertyInteger('HeatRequestID', 0);


			$ValveRequestID = $this->RegisterVariableBoolean('ValveRequest', 'Valve Request');
			$HeatRequestID = $this->RegisterVariableBoolean('HeatRequest', 'Heat Request');
			$ValveID = $this->RegisterVariableBoolean('ValveStatus', 'Valve');
			$StatusID = $this->RegisterVariableString('Status', 'Status', '', 2);
			


        	//Timers
        	//$this->RegisterTimer('OffTimer', 0, "THL_Stop(\$_IPS['TARGET']);");
			$this->RegisterTimer('UpdateRemainingTimer', 0, "VALVE_ValveRequestAction(\$_IPS['TARGET']);");
			
			//Scripts
			$scriptID = $this->RegisterScript("TextSkript", "VALVE_ValveRequestAction(\$_IPS['TARGET']);");

			//$eid = IPS_CreateEvent(0);        //triggered event
			//IPS_SetEventTrigger($eid, 1, $ValveRequestID); //On change of variable with ID 15 754
			//IPS_SetParent($eid, $_IPS['SELF']); //Assigning the event
			//IPS_SetEventActive($eid, true); 
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

			//$this->RegisterMessage($ValveRequestID, VM_UPDATE);
			//$this->RegisterReference($ValveRequestID);

			$this->RegisterMessage($this->ReadPropertyInteger('ValveRequest')), VM_UPDATE);
			$this->RegisterReference($this->ReadPropertyInteger('ValveRequest')); 


		}

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data) 
		{
 			IPS_LogMessage("MessageSink", "Message from SenderID ".$SenderID." with Message ".$Message."\r\n Data: ".print_r($Data, true));
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

		public function Check_HeatRequestID()
		{
			$ValveLink = $this->ReadPropertyInteger('HeatRequestID');
			echo $ValveLink;
			//echo $this->ReadPropertyInteger('HeatRequestID');
		}

		public function Scan()
		{
			$ValveLink = $this->ReadPropertyInteger('ValveID');
			echo $ValveLink;
			IPS_LogMessage('ValveDevice', 'Hello Semaphore in Scan');
		}	

		public function ValveRequestAction()
		{
			IPS_LogMessage('Valve', 'RequestAction triggered');
		}


	}
