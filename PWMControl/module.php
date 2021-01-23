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
		}

	}