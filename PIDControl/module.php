<?php
	class PIDControl extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			 //Properties
			 $this->RegisterPropertyFloat('KP',1);
			 $this->RegisterPropertyFloat('KI',1);
			 $this->RegisterPropertyFloat('KD',1);
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

	}