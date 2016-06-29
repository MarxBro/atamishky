<?php

/*
 A demonstration of Moodle 2 Web services.
 Written by Jocelyn Ireson-Paine,
http://www.j-paine.org .

 The 'curl' that this uses comes from
https://github.com/moodlehq/sample-ws-clients/blob/master/PHP-REST/curl.php .
 */


 /* Returns a structure defining
    a test user whose name, password, etc. end
    in $n.
 */
 function make_test_user( $n ) 
 {
   $user = new stdClass();
   $user->username = 'testusername' . $n;
   $user->password = 'testpassword' . $n;
   $user->firstname = 'testfirstname' . $n;
   $user->lastname = 'testlastname' . $n;
   $user->email = 'testemail' . $n . '@moodle.com';
   $user->auth = 'manual';
   $user->idnumber = 'testidnumber' . $n;
   $user->lang = 'en';
   $user->theme = 'standard';
   $user->timezone = '0';
   $user->mailformat = 0;
   $user->description = 'Hello World!';
   $user->city = 'testcity' . $n;
   $user->country = 'uk';
   return $user;
 }


 /* Returns a structure defining
    a test course whose name etc. end
    in $n.

    I have set the category ID to 1.
    This works, but is almost certainly wrong.
    I need to find out what it should be.
 */
 function make_test_course( $n ) 
 {
   $course = new stdClass();
   $course->fullname = 'testcourse' . $n;
   $course->shortname = 'testcourse' . $n;
   $course->categoryid = 1;
   return $course;
 }


 /* Creates a user from a
    structure defining a user. If the
    creation succeeds, returns the 
    ID for this user. If not, throws
    an exception whose text is the XML
    returned by Moodle.
 */
 function create_user( $user, $token )
 {
   $users = array( $user );
   $params = array( 'users' => $users );

   $response = call_moodle( 'moodle_user_create_users', $params, $token );

   print "Response from moodle_user_create_users: \n";
   print_r( $response );

   if ( xml_is_exception( $response ) )
     throw new Exception( $response );
   else {
     $user_id = success_xml_to_id( $response );
     return $user_id;
   }
 }


 /* Returns the XML string containing Moodle's
    data for user ID $id. Does not
    check for an error response, because if there
    is no such user, Moodle seems just to
    return a piece of XML containing no user
    data.
 */
 function get_user( $user_id, $token )
 {
   $userids = array( $user_id );
   $params = array( 'userids' => $userids );

   $response = call_moodle( 'moodle_user_get_users_by_id', $params, $token );

   print "Response from moodle_user_get_users_by_id: \n";
   print_r( $response );

   return $response;
 }


 /* Deletes the user with ID $user_id. 
    If the delete fails, throws
    an exception whose text is the XML
    returned by Moodle.
 */
 function delete_user( $user_id, $token )
 {
   $userids = array( $user_id );
   $params = array( 'userids' => $userids );

   $response = call_moodle( 'moodle_user_delete_users', $params, $token );

   print "Response from moodle_user_delete_users: \n";
   print_r( $response );

   if ( xml_is_exception( $response ) )
     throw new Exception( $response );
 }


 /* Assigns the role with $role_id to the user with $user_id.

    I haven't tested this, because I can't find a function
    for converting the roles we have to role IDs.
 */
 function assign_role( $role_id, $user_id, $context_id, $token )
 {
   $assignment = array( 'roleid' => $role_id, 'userid' => $user_id, 'contextid' => $context_id );
   $assignments = array( $assignment );
   $params = array( 'assignments' => $assignments );

   $response = call_moodle( 'moodle_role_assign', $params, $token );

   print "Response from moodle_role_assign: \n";
   print_r( $response );
 }


 /* Creates a course from a
    structure defining a course. If the
    creation succeeds, returns the 
    ID for this course. If not, throws
    an exception whose text is the XML
    returned by Moodle.
 */
 function create_course( $course, $token ) 
 {
   $courses = array( $course );
   $params = array( 'courses' => $courses );

   $response = call_moodle( 'moodle_course_create_courses', $params, $token );

   print "Response from moodle_course_create_courses: \n";
   print_r( $response );

   if ( xml_is_exception( $response ) )
     throw new Exception( $response );
   else {
     $course_id = success_xml_to_id( $response );
     return $course_id;
   }
 }


 /* Enrols the user into the course with the specified role.
    Does not yet check for errors.

    I haven't tested this, because our Moodle is
    missing moodle_enrol_manual_enrol_users.
 */
 function enrol( $user_id, $course_id, $role_id, $token ) 
 {
   $enrolment = array( 'roleid' => $role_id, 'userid' => $user_id, 'courseid' => $course_id );
   $enrolments = array( $enrolment );
   $params = array( 'enrolments' => $enrolments );

   $response = call_moodle( 'moodle_enrol_manual_enrol_users', $params, $token );

   print "Response from moodle_enrol_manual_enrol_users: \n";
   print_r( $response );
 }


 /* Calls the Moodle at http://moodle.jocelyn_ireson-paine.com, invoking the specified
    function on $params. Also takes a token. 
    Returns Moodle's response as a string containing XML.
 */ 
 function call_moodle( $function_name, $params, $token )
 {
   $domain = 'http://moodle.jocelyn_ireson-paine.com';

   $serverurl = $domain . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$function_name;

   require_once( './curl.php' );
   $curl = new curl;

   $response = $curl->post( $serverurl . $restformat, $params );
   return $response;
 }


 /* Given a string containing XML returned
    by a successful user creation or course
    creation, parses it and returns the user or course ID.
    Undefined if the XML does not contain such an ID,
    for example if it's an error response.
 */
 function success_xml_to_id( $xml_string )
 {
   $xml_tree = new SimpleXMLElement( $xml_string ); 

   $value = $xml_tree->MULTIPLE->SINGLE->KEY->VALUE;
   $id = sprintf( "%s", $value );
   // See discussion on http://php.net/manual/es/book.simplexml.php ,
   // especially the posting for "info at kevinbelanger dot com 20-Jan-2011 05:07".
   // There is a bug in the XML parser whereby it doesn't return the
   // text associated with property [0] of a node. The above
   // posting uses sprintf to force a conversion to string.

   return $id;
 } 


 /* True if $xml_string's top-level is
    <EXCEPTION>. I use this to check for error
    responses from Moodle.
 */
 function xml_is_exception( $xml_string )
 {
   $xml_tree = new SimpleXMLElement( $xml_string ); 

   $is_exception = $xml_tree->getName() == 'EXCEPTION';
   return $is_exception;
 } 


 function demo()
 {
   try {

     print "Demo of Moodle Web services\n";
     print "===========================\n";

     $token = '0ea793fubf08r68db36fe8f632304x20';
     print "\nUses this token which I created manually: " . $token . "\n"; 

     print "\nWill now create a user from this data:\n";
     $user_suffix = 100;
     $user_data = make_test_user( $user_suffix );
     print_r( $user_data ); 
     print "\n";

     $user_id = create_user( $user_data, $token );
     print "\nUser's ID = " . $user_id . "\n";

     print "\nWill now get the user details using that ID:\n";
     $xml_user_data = get_user( $user_id, $token );
     print "\nUser details:\n";
     print $xml_user_data;

     print "\nWill now create a course from this data:\n";
     $course_suffix = 100;
     $course_data = make_test_course( $course_suffix );
     print_r( $course_data ); 
     print "\n";

     $course_id = create_course( $course_data, $token );
     print "\nCourse ID = " . $course_id . "\n";

     print "\nWill now enrol the user:\n";
     $role_id = 1;
                // I don't know how to get the IDs for the roles we actually have.
     enrol( $user_id, $course_id, $role_id, $token );

     print "\nWill now delete the user:\n";
     delete_user( $user_id, $token );

   } 
   catch ( Exception $e ) {
     print "\nCaught exception:\n" . $e->getMessage() . "\n";
   }
 }


 demo();


 ?>
