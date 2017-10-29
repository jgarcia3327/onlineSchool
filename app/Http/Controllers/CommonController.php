<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\CreditController;
use Carbon\Carbon;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Feedback;
use DateTime;

class CommonController {

  public function getCourses() {
    return array(
      "IELTS/TOEIC/TOEFL" => "IELTS/TOEIC/TOEFL",
      "BUSINESS/OFFICE ENGLISH" => "BUSINESS/OFFICE ENGLISH",
      "ENGLISH FOR KIDS" => "ENGLISH FOR KIDS",
      "PUBLIC SPEAKING" => "PUBLIC SPEAKING",
      "WRITING AND COMPOSITION" => "WRITING AND COMPOSITION",
      "READING AND COMPREHENSION" => "READING AND COMPREHENSION",
      "LISTENING" => "LISTENING"
    );
  }

  public function getFeaturedFeeback() {
    return Feedback::select("feedback.*","students.fname AS student", "teachers.fname AS teacher")->leftJoin("students","students.user_id","=","feedback.user_id")->leftJoin("teachers","teachers.user_id","=","feedback.user_id")->where([['feedback.active','=',1],['featured','=',1]])->get();
  }

  public function getAdmin($user_id) {
    $teacher = Teacher::select("teachers.*","users.email","users.is_admin")->leftJoin("users","users.id","=","teachers.user_id")->where('user_id', $user_id)->first();
    if ($teacher != null) {
      if ($teacher->is_admin == 1)
        return $teacher;
      else return null;
    }
    $student = Student::select("students.*","users.email","users.is_admin")->leftJoin("users","users.id","=","students.user_id")->where('user_id', $user_id)->first();
    if ($student != null && $student->is_admin == 1) {
      return $student;
    }
    return null;
  }

  public function getEnglishHoursBankAccount() {
    return array(
      "Tên đơn vị thụ hưởng / Tên tài khoản" => "Iucu Jannet",
      "Tài khoản thụ hưởng / Số tài khoản" => "142 120 507 9360",
      "Tỉnh/ Thành phố" => "Hà Nội",
      "Tại ngân hàng" => "NH Nông Nghiệp và Phát Triền Nông Thôn (AGRIBANK)",
      "Chi nhánh" => "NN&PTNT Đông Hà Nội",
      "Nội dung chuyển tiền" => "(Họ tên đầy đủ và số điện thoại của bạn)",
    );
  }

  public function getEnglishHoursBankAccountEN() {
    return array(
      "Bank" => "AGRIBANK",
      "Account Name" => "Jannet Iucu",
      "Acount Number" => "1421205079360"
    );
  }

  public function getStudentCreditCount($user_id) {
    return CreditController::getCreditCount($user_id);
  }

  public function getCurrentDateTime() {
    return Carbon::now();
  }

  public function getCreditLessonsValidity() {
    return CreditController::getCreditLessonsValidity();
  }

  public function getCreditLessonsStr() {
    return CreditController::getCreditLessonsStr();
  }

  public function getCreditLessons() {
    return CreditController::getCreditLessons();
  }

  public function getSchoolMaxYear() {
    return 1979;
  }

  public function getActiveTeacherProfile() {
    return TeacherProfileController::getActiveTeacherProfile();
  }

  public function getActiveTeachers() {
    $condition = [
      ['users.active','=',1],
      //['users.id','<>',Auth::user()->id],
      ['users.is_student', '=', 0]
    ];
    $users = User::select("users.*","teachers.fname","teachers.lname")->leftJoin("teachers","teachers.user_id","users.id")->where($condition)->orderBy("teachers.fname","asc")->get();
    return $users;
  }

  public function getActiveStudents() {
    $condition = [
      ['users.active','=',1],
      ['users.id','<>',Auth::user()->id],
      ['users.is_student', '=', 1]
    ];
    $users = User::select("users.*","students.fname","students.lname")->leftJoin("students","students.user_id","users.id")->where($condition)->get();
    return $users;
  }

  public function getActiveUsers() {
    $condition = [
      ['users.active','=',1],
      ['users.id','<>',Auth::user()->id]
    ];
    $users = User::select("users.*","teachers.fname AS tfname","teachers.lname AS tlname","students.fname","students.lname")->leftJoin("teachers","teachers.user_id","users.id")->leftJoin("students","students.user_id","users.id")->where($condition)->get();
    return $users;
  }

  public function getMonthStr($month) {
    return $this->getMonths()[$month];
  }

  public function getMonths(){
    return array(
      '01' => "January",
      '02' => "February",
      '03' => "March",
      '04' => "April",
      '05' => "May",
      '06' => "June",
      '07' => "July",
      '08' => "August",
      '09' => "September",
      '10' => "October",
      '11' => "November",
      '12' => "December"
    );
  }

  public function getStartAndEndDate($week, $year) {

    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7*$week)+1-$day)*24*3600;
    $return[0] = date('Y-m-d', $time);
    $time += 6*24*3600;
    $return[1] = date('Y-m-d', $time);
    return $return;
  }

  public function getFormattedDateVietNam($date) {
    return $this->getFormattedDate($date);
    //FIXME
    setlocale(LC_ALL, 'vi_VN.utf8');
    //return date('l, F j, Y', strtotime($date));
    return strftime('%A, %B %e, %Y', strtotime($date));
  }

  public function getFormattedDate($date) {
    setlocale(LC_ALL, 'en_EN');
    //return date('l, F j, Y', strtotime($date));
    return strftime('%A, %B %e, %Y', strtotime($date));
  }

  public function getFormattedDateTimeRange($date) {
    $dateFormat = date('l, F j, Y', strtotime($date));
    $time = substr(strstr($date," "),1,5);
    $hour = $hourTo = strstr($time,":",true);
    if (strstr($time,":") == ":30"){
      $hourTo += 1;
      $ampmTo = $hourTo >= 12? "PM" : "AM";
      $ampmTo = $hourTo == 24? "AM" : $ampmTo;
      $hourTo = $hourTo >= 13 ? $hourTo - 12 : $hourTo;
      $hourMinuteTo = $hourTo.":00";
    }
    else {
      $ampmTo = $hourTo >= 12? "PM" : "AM";
      $hourTo = $hourTo >= 13 ? $hourTo - 12 : $hourTo;
      $hourMinuteTo =  $hourTo.":30";
    }
    $ampmFrom = $hour >= 12? "PM" : "AM";
    $hourMinuteFrom = $hour >= 13? ($hour-12).strstr($time,":") : $time;
    $dateFormat = date('l, F j, Y', strtotime($date));
    return $dateFormat." | ".$hourMinuteFrom." ".$ampmFrom." - ".$hourMinuteTo." ".$ampmTo;
  }

  public function getFormattedDateTimeRangeMilitary($date) {
    $dateFormat = date('Y-m-d', strtotime($date));
    $time = substr(strstr($date," "),1,5);
    $timeTo = null;
    $hour = strstr($time,":",true);
    if (strstr($time,":") == ":30"){
      $timeTo = ($hour + 1).":00";
    }
    else {
      $timeTo = $hour.":30";
    }
    $hourMinuteRange = $time." - ".$timeTo;

    // Specify Today, Yesterday, Tomorrow
    $today = new DateTime(); // This object represents current date/time
    $today->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

    $match_date = DateTime::createFromFormat( "Y-m-d H:i:s", $date );
    $match_date->setTime( 0, 0, 0 ); // reset time part, to prevent partial comparison

    $diff = $today->diff( $match_date );
    $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

    $forSorting = $match_date->getTimestamp();
    switch( $diffDays ) {
        case 0:
            $dateFormat = "<strong>Today</strong>";
            $forSorting = $forSorting."-0";
            break;
        case -1:
            $dateFormat = "Yesterday";
            $forSorting = $forSorting."-1";
            break;
        case +1:
            $dateFormat = "Tomorrow";
            $forSorting = $forSorting."-2";
            break;
        default:
            //Other datetime
            $forSorting = $forSorting."-3";
    }

    return "<i style='display:none;'>".$forSorting."</i>".$dateFormat." | ".$hourMinuteRange;
  }

  public function getDeleteModal($id, $link) {
      return '<!-- Modal -->
  <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="modalLabel">Confirm Delete</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      Data cannot be recovered once deleted.
    </div>
    <div class="modal-footer">
      <form action="'.$link.'" method="POST">
      <input type="hidden" name="_method" value="PUT">
      <button type="submit" class="btn btn-danger">Delete</button>
      </form>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    </div>
  </div>
  </div>
  </div>';
  }

  public function getCountries() {
      return array(
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "IO" => "British Indian Ocean Territory",
        "BN" => "Brunei Darussalam",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos (Keeling) Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo",
        "CD" => "Congo, the Democratic Republic of the",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "CI" => "Cote D'Ivoire",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands (Malvinas)",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and Mcdonald Islands",
        "VA" => "Holy See (Vatican City State)",
        "HN" => "Honduras",
        "HK" => "Hong Kong",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran, Islamic Republic of",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KP" => "Korea, Democratic People's Republic of",
        "KR" => "Korea, Republic of",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Lao People's Democratic Republic",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libyan Arab Jamahiriya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macao",
        "MK" => "Macedonia, the Former Yugoslav Republic of",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "MX" => "Mexico",
        "FM" => "Micronesia, Federated States of",
        "MD" => "Moldova, Republic of",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territory, Occupied",
        "PA" => "Panama",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RE" => "Reunion",
        "RO" => "Romania",
        "RU" => "Russian Federation",
        "RW" => "Rwanda",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "ST" => "Sao Tome and Principe",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syrian Arab Republic",
        "TW" => "Taiwan, Province of China",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania, United Republic of",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "UM" => "United States Minor Outlying Islands",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "VG" => "Virgin Islands, British",
        "VI" => "Virgin Islands, U.s.",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe"
        );
  }
}
?>
