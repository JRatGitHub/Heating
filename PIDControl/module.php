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
			
			//Variables
			$Setpoint = $this->RegisterVariableInteger('SETPOINT','Setpoint','Precentage');
			$this->CreateCategory('ViaFunction');
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

	}