<?php 

namespace Blocks\GoToTestsHub;

class DataGetter 
{
	private $cohortName = false;
	private $hubsCategory = 3;

	function __construct()
	{
		$this->cohortName = mb_substr($this->get_student_cohort_name(), 2, 3);
	}

	public function get_tests_hub_id(): int
	{
		global $USER;
		if( $this->cohortName )
			$onlyactive = true;

			$courses = enrol_get_all_users_courses($USER->id, $onlyactive);
			foreach( $courses as $course )
			{
				if( $this->cohortName === explode(',', $course->shortname)[0]
					&&
					$course->category == $this->hubsCategory )
				{
					return $course->id;
				}
			}
		return Main::HUB_NOT_EXIST;
	}

	private function get_student_cohort_name(): string
	{
		global $DB, $USER;

		$sql = 'SELECT c.name 
				FROM {cohort_members} AS cm 
				INNER JOIN {cohort} AS c 
				ON cm.cohortid = c.id 
				WHERE cm.userid = ?
				AND c.name REGEXP \'^[0-9]{2}.+\'';
		$params = [$USER->id];
		//! В теории может быть несколько групп
		// get_field_sql return false if not found
		return $DB->get_field_sql($sql, $params);
	}
}