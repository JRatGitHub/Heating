<?php
	class PIDControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			 //Properties
			 $this->RegisterPropertyFloat('KP',0.5);
			 $this->RegisterPropertyFloat('KI',1);
			 $this->RegisterPropertyFloat('KD',1);

			 $this->RegisterPropertyInteger('SamplingTime',120);

			 $this->RegisterPropertyInteger('OutputMin',10);
			 $this->RegisterPropertyInteger('OutputMax',100);
			 $this->RegisterPropertyInteger('RoomSetpointID', 0);
			 $this->RegisterPropertyInteger('RoomTemperatureID', 0);
			 $this->RegisterPropertyInteger('OutputPWM', 0);
			 $this->RegisterPropertyBoolean('DisplayStatus', false);

			//Variables
			$Output = $this->RegisterVariableInteger('OUTPUT','Output','~Intensity.100');
			
			//$this->CreateCategory('ViaFunction');
			//IPS_SetName($CatID, "CategoryDuringCreate");
			//IPS_SetParent($CatID, $this->InstanceID);
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

			//Register variable if enabled
			$this->MaintainVariable('Status', 'Status', VARIABLETYPE_STRING, '', 10, $this->ReadPropertyBoolean('DisplayStatus'));

		//	$CatID = IPS_CreateCategory();
		//	IPS_SetName($CatID, "Category");
		//	IPS_SetParent($CatID, $this->InstanceID);
		}

		public function CreateCategory($Ident){
			$eid = @$this->GetIDForIdent($Ident);
			if($eid === false) {
		    	$eid = 0;
			} 
			//elseif(IPS_GetEvent($eid)['EventType'] <> $Typ) {
		    //	IPS_DeleteEvent($eid);
		    //	$eid = 0;
			//}
			//we need to create one
			if ($eid == 0) {
				$CatID = IPS_CreateCategory();
				IPS_SetName($CatID, $Ident);
				IPS_SetParent($CatID, $this->InstanceID);	
				//$EventID = IPS_CreateEvent($Typ);
		    	//IPS_SetParent($EventID, $Parent);
		    	//IPS_SetIdent($EventID, $Ident);
		    	//IPS_SetName($EventID, $Name);
		    	//IPS_SetPosition($EventID, $Position);
		    	//IPS_SetEventActive($EventID, true);  
			}
		//	$CatID = IPS_CreateCategory();
		//	IPS_SetName($CatID, "CreateCategory");
		//	IPS_SetParent($CatID, $this->InstanceID);	
		}

		public function ToggleDisplayInterval($visible) {
			$this->UpdateFormField('UpdateInterval', 'visible', $visible);
		}
	}