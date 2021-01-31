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
			
			$CatID = IPS_CreateCategory();
			IPS_SetName($CatID, "CategoryDuringCreate");
			IPS_SetParent($CatID, $this->InstanceID);
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

			$CatID = IPS_CreateCategory();
			IPS_SetName($CatID, "Category");
			IPS_SetParent($CatID, $this->InstanceID);
		}

		public function CreateCategory($CatName){
			$CatID = IPS_CreateCategory();
			IPS_SetName($CatID, "CreateCategory");
			IPS_SetParent($CatID, $this->InstanceID);
			
		}

	}