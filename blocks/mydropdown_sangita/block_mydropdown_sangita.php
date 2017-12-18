<?php

defined('MOODLE_INTERNAL') || die();



class block_mydropdown_sangita extends block_base
{

	public function init()
	{
		$this->title = get_String('value','block_mydropdown_sangita');
	}


	// public function get_content()
	// {
	// 	global $CFG , $DB ,$USER, $OUTPUT,$PAGE;

	// 	if($this->content != null)
	// 	{
	// 		return $this->content;
	// 	}

	// 	if(!isloggedin() or isguestuser())
	// 	{
	// 		return '';
	// 	}	


	// 	$this->content = new stdclass;
	// 	$this->content->text = '';
	// 	$this->content->text .= '<table border="1 px solid black">
	// 							<tr>
	// 								<th>S.No</th>
	// 								<th>Category</th>
	// 								<th>Course</th>

	// 							</tr>';
	// 							//$course = array("C Language","Java Language","HTML CSS","DATABASE","Oops");

	// 						//	$i = '';
	// 						//	foreach($course as $value)
	// 						//	{	
	// 							/*$this->content->text .= '<tr>
	// 									<td>'.$i.'</td>
	// 									<td>'.$value.' </td>s
										
	// 								</tr>';
	// 							}
	// 							$this->content->text .='</table>';*/
	// 	$courses = $DB->get_records_sql('SELECT id,category,fullname FROM {course}', array());
	// 	unset($courses[1]);

	// 	//$conditions=(id==4);

	// 	$value1=$DB->get_record('course', array('id'=>4), 'id,shortname,fullname,category') ;
	// 	print_object($value1);
	// 	//var_dump($courses);
	// 	$i = 1;
	// 	foreach($courses as $value)
	// 	{
	// 		//print_object($value);
	// 		$category = $DB->get_record_sql('SELECT name FROM {course_categories} WHERE id = ?', array($value->id));
	// 		if($category)
	// 		{
	// 		$this->content->text.=
	// 		'<tr>
	// 		<td>'.$i.'</td>
	// 		<td>'.$category->name.'</td>
	// 		<td>'.$value->fullname.'</td>
	// 		</tr>';
	// 	}
			
	// 		$i++;
	// 	}	
		


	// 	return $this->content;
	// }
 /**
 * allow the block to have a configuration page
 *
 * @return boolean
 */
    public function has_config() {
        return false;
    }

	/**
     * allow more than one instance of the block on a page
     *
     * @return boolean
     */
    public function instance_allow_multiple() {
        //allow more than one instance on a page
        return false;
    }

    /**
     * allow instances to have their own configuration
     *
     * @return boolean
     */
    function instance_allow_config() {
        //allow instances to have their own configuration
        return false;
    }

    /**
     * instance specialisations (must have instance allow config true)
     *
     */
    public function specialization() {
    }

    /**
     * locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('all'=>true);
    }

    /**
     * post install configurations
     *
     */
    public function after_install() {
    }

    /**
     * post delete configurations
     *
     */
    public function before_delete() {
    }

}
?>