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
			$OpenTimeID = $this->RegisterVariableInteger('OpenTime', 'Open time', 'Minuten',0);
			
        	//Timers
			$this->RegisterTimer('OpeningTimer', 0, "VALVE_StartValveOpening(\$_IPS['TARGET']);");
			$this->RegisterTimer('ClosingTimer', 0, "VALVE_StartValveClosing(\$_IPS['TARGET']);");
			$this->RegisterTimer('OpenTimeCounter', 0, "VALVE_IncrementValveOpenCounter(\$_IPS['TARGET']);");



			// events
			$this->RegisterResetCounter('ResetCounter', 'VALVE_ResetValveOpenCounter($id)');	
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

			$this->RegisterMessage($this->GetIDForIdent('ValveRequest'), VM_UPDATE);
			$this->RegisterReference($this->GetIDForIdent('ValveRequest')); 
			//IPS_LogMessage('Valve:Register', $this->GetIDForIdent('ValveRequest'));

		}

		protected function RegisterResetCounter($ident, $script) {
			$id = @IPS_GetObjectIDByIdent($ident, $this->InstanceID);
		
			if ($id && IPS_GetEvent($id)['EventType'] <> 1) {
			  IPS_DeleteEvent($id);
			  $id = 0;
			}
		
			if (!$id) {
			  $id = IPS_CreateEvent(1);
			  IPS_SetParent($id, $this->InstanceID);
			  IPS_SetIdent($id, $ident);
			  IPS_SetEventCyclicTimeFrom($id, 0, 0, 0);
			}
		
			IPS_SetName($id, $ident);
			IPS_SetHidden($id, true);
			IPS_SetEventScript($id, "\$id = \$_IPS['TARGET'];\n$script;");
			IPS_SetEventActive($id, true);
		  }

		public function MessageSink($TimeStamp, $SenderID, $Message, $Data) 
		{
			 IPS_LogMessage("MessageSink", "Message from SenderID ".$SenderID." with Message ".$Message."\r\n Data: ".print_r($Data, true));
			 
			 if ($Message == VM_UPDATE) {
				IPS_LogMessage("MessageSink", "Updated");
				if ($SenderID == $this->GetIDForIdent('ValveRequest')){
					IPS_LogMessage("MessageSink", "ValveRequest Updated");
					if (GetValueBoolean($this->GetIDForIdent('ValveRequest'))==TRUE){
						IPS_LogMessage("MessageSink", "ValveRequest is Open");
						$this->ValveOn;
						SetValueString($this->GetIDForIdent('Status'),"Valve opening ...");
						//Start OpeningTimer
						$duration = $this->ReadPropertyInteger('ValveOpenDelay');
						$this->SetTimerInterval('OpeningTimer', $duration * 1000);
						$this->SetTimerInterval('OpenTimeCounter', 60 * 1000);
					} else {
						IPS_LogMessage("MessageSink", "ValveRequest is close");
						$this->ValveOff;
						SetValueString($this->GetIDForIdent('Status'),"Valve closing ...");
						//Start ClosingTimer
						$duration = $this->ReadPropertyInteger('ValveCloseDelay');
						$this->SetTimerInterval('ClosingTimer', $duration * 1000);

						$this->SetTimerInterval('OpenTimeCounter', 0);
						
					}
				}
			 }
		}

		public function StartValveClosing()
		{
			IPS_LogMessage("MessageSink", "StartValveOpening triggered");
			
			//Disable ClosingTimer
			$this->SetTimerInterval('ClosingTimer', 0);
			SetValueString($this->GetIDForIdent('Status'),"Valve closed");
			SetValueBoolean($this->GetIDForIdent('ValveStatus'),False);
		}

		public function StartValveOpening()
		{
			IPS_LogMessage("MessageSink", "StartValveOpening triggered");
			
			//Disable OpeningTimer
			$this->SetTimerInterval('OpeningTimer', 0);
			SetValueString($this->GetIDForIdent('Status'),"Valve open");
			SetValueBoolean($this->GetIDForIdent('ValveStatus'),True);
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

		public function IncrementValveOpenCounter()
		{
			//$ValveLink = $this->ReadPropertyInteger('ValveID');
			//echo $ValveLink;
			IPS_LogMessage('MessageSink', 'ResetValveOpenCounter triggered');
			SetValueInteger($this->GetIDForIdent('OpenTime'),GetValueInteger($this->GetIDForIdent('OpenTime'))+1);
		}	

		public function ResetValveOpenCounter()
		{
			//$ValveLink = $this->ReadPropertyInteger('ValveID');
			//echo $ValveLink;
			IPS_LogMessage('MessageSink', 'ResetValveOpenCounter triggered');
			SetValueInteger($this->GetIDForIdent('OpenTime'),0);
		}	


		public function ValveRequestAction()
		{
			IPS_LogMessage('Valve', 'RequestAction triggered');
		}


	}
