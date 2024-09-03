<?php 

namespace Blocks\GoToTestsHub;

class DataGetter 
{
    private $cohortName;
    private $testHubId;

    function __construct()
    {
        $this->cohortName = $this->get_student_cohort_name();

        if($this->is_cohort_name_exists())
        {
            $this->testHubId = $this->get_hub_course_id();
        }
        else 
        {
            $this->testHubId = Main::HUB_NOT_EXIST;
        }
    }

    public function get_tests_hub_id()
    {
        return $this->testHubId;
    }

    private function get_student_cohort_name()
    {
        global $DB, $USER;

        $sql = 'SELECT c.name 
                FROM {cohort_members} AS cm 
                INNER JOIN {cohort} AS c 
                ON cm.cohortid = c.id 
                WHERE cm.userid = ?';
        $params = array($USER->id);

        return $DB->get_field_sql($sql, $params);
    }

    private function is_cohort_name_exists() : bool 
    {
        if(empty($this->cohortName))
        {
            return false;
        }
        else 
        {
            return true;
        }
    }

    private function get_hub_course_id()
    {
        $courses = $this->student_courses();
        $courses = $this->get_only_first_part_of_name($courses);

        foreach($courses as $course)
        {
            if(mb_stripos($this->cohortName, $course->name) !== false)
            {
                return $course->id;
            }
        }

        return Main::HUB_NOT_EXIST;
    }

    private function student_courses()
    {
        global $USER;
        $onlyactive = true;
        return enrol_get_all_users_courses($USER->id, $onlyactive);
    }

    private function get_only_first_part_of_name($courses)
    {
        foreach($courses as $course)
        {
            $parts = explode(',', $course->name);
            $course->name = $parts[0];
        }

        return $courses;
    }

}
