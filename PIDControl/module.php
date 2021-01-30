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

			$CatID = IPS_CreateCategory();       // Kategorie anlegen
			IPS_SetName($CatID, "Category"); // Kategorie benennen
			IPS_SetParent($CatID, $this->InstanceID); // Kategorie einsortieren unter dem Objekt mit der ID "12345"
		//	IPS_CreateCategory( $this->InstanceID)
		}

	}