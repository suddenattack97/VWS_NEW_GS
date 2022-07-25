<?
/***********************************************************
 * 파 일 명 : LocalInfo.class                              *
 * 작 성 일 : 2010-04-01                                   *
 * 수 정 일 : 2010-04-01                                   *
 * 작 성 자 : 남상식                                       *
 * 소    속 : (주)화진티엔아이 기술연구소                  *
 * 작성목적 : 장비정보                                       *
 ***********************************************************/

Class RtuInfo {

    private $DB;

  public $RTU_ID;
  public $AREA_CODE;
  public $COMBI_TYPE;
  public $RTU_TYPE;
  public $ORGAN_ID;
  public $SIGNAL_ID;
  public $RTU_NAME;
  public $LINE_NO;
  public $MODEL_NO;
  public $CONNECTION_INFO;
  public $PORT;
  public $BAUDRATE;
  public $SORT_FLAG;
  public $RTU_STATE;
  public $AMP_STATE;
  public $CALL_LAST;
  public $EVENT_QTAIL;
  public $WARNING_SMS;
  public $DANGER_SMS;
  public $REG_DATE;

  public $POINTX;
  public $POINTY;

  public $GROUP_NAME;

  public $SENSERTYPE;
  public $AVRCHECK;

    public $rsCnt=0;

  Private $getCalc = 0.01;

    /* 생성자
       전체호출   : RtuInfo($DB)
     RTU별 호출 : RtuInfo($DB, 3)
       평균유무   : RtuInfo($DB, 3, 1)
    */
    function RtuInfo($DB, $senser_type=null, $avrcheck=null) {

        $this->DB = $DB;
         $this->SENSERTYPE  = $senser_type;
        $this->AVRCHECK = $avrcheck;
    }



    /*
     * 센서별 지점정보호출 (사용안함)
     */
    function getSensorRtuInfo($rtu_type=null) {

        unset($this->AREA_CODE, $this->RTU_NAME, $this->AVR_TYPE, $this->CALL_LAST, $this->rsCnt);

        $sql  = "       select RTU_ID, AREA_CODE, COMBI_TYPE, RTU_TYPE, ORGAN_ID, SIGNAL_ID, RTU_NAME, LINE_NO, MODEL_NO, CONNECTION_INFO, PORT, BAUDRATE, SORT_FLAG, RTU_STATE, AMP_STATE, CALL_LAST, EVENT_QTAIL, WARNING_SMS, DANGER_SMS, REG_DATE  ";
        $sql  .= "      from RTU_INFO   ";

        if(!$empty($rty_type)) $sql  .= " where RTU_TYPE = '" . $rtu_type ."' ";

        $sql  .= "      order by SORT_FLAG ASC   ";

        $rs = $this->DB->execute($sql);
        //echo $sql;
        $i=0;
        while (!$rs->eof) {
            $this->AREA_CODE[$i]    = $rs->AREA_CODE;
            $this->RTU_NAME[$i]   = iconv("UTF-8","EUC-KR",$rs->RTU_NAME);
            $this->AVR_TYPE[$i]   = $rs->AVR_TYPE;
            $this->CALL_LAST[$i]  = $rs->CALL_LAST;
            $rs->movenext();
            $i++;
        }
        $this->rsCnt = $i;
        $this->DB->parseFree();
    }

    /* 환경정보 *******************************************
            RTU_TYPE    CHAR(3)     NO  UNI         "장비 구분
            B00:방송장비
            A00:AWS
            R00:강우량계
            F00:수위계
            RF0:강우수위계
            F10:수위댐자료
            S00:적설계"
  */

    /*
     * 장비위치 정보호출
     */
    function getLocation() {

        unset($this->RTU_NAME,$this->RTU_ID,$this->CONNECTION_INFO,$this->RTU_TYPE,$this->CALL_LAST,$this->EVENT_QTAIL,$this->POINTX, $this->POINTY,$this->rsCnt);

    $SQL = " SELECT R.RTU_NAME, R.RTU_ID, R.CONNECTION_INFO, R.RTU_TYPE, R.CALL_LAST, R.EVENT_QTAIL, L.POINTX, L.POINTY, R.AREA_CODE ";
    $SQL.= " FROM   RTU_LOCATION L RIGHT JOIN RTU_INFO R ";
    $SQL.= " ON     R.RTU_ID = L.RTU_ID ";
    //$SQL.= " WHERE    R.ORGAN_ID='".CK_ORGAN_ID."'";

        $rs = $this->DB->execute($SQL);

        for($i=0; $i<$this->DB->NUM_ROW(); $i++){
            $this->RTU_NAME[$i]         = $rs[$i]['RTU_NAME'];
            $this->RTU_ID[$i]               = $rs[$i]['RTU_ID'];
            $this->CONNECTION_INFO[$i]  = $rs[$i]['CONNECTION_INFO'];
            $this->RTU_TYPE[$i]         = $rs[$i]['RTU_TYPE'];
            $this->CALL_LAST[$i]        = $rs[$i]['CALL_LAST'];
            $this->EVENT_QTAIL[$i]      = $rs[$i]['EVENT_QTAIL'];
            $this->POINTX[$i]           = $rs[$i]['POINTX'];
            $this->POINTY[$i]           = $rs[$i]['POINTY'];
            $this->AREA_CODE[$i]            = $rs[$i]['AREA_CODE'];
        }
        unset($rs);
        $this->rsCnt = $i;
        $this->DB->parseFree();
    }

    /*
     * 사용자 방송장비 권한 리스트
     */
    function getUserLocation() {

        unset($this->GROUP_NAME,$this->RTU_NAME,$this->RTU_ID,$this->CONNECTION_INFO,$this->RTU_TYPE,$this->CALL_LAST,$this->EVENT_QTAIL,$this->POINTX, $this->POINTY,$this->rsCnt);

    $SQL = " SELECT * FROM ( SELECT ORGAN_ID, TREE_DEPTH, GROUP_ID, GROUP_NAME, 0 RTU_ID, 0 RTU_NAME, AREA_CODE, PARENT_ID, TREE_PATH FROM GROUP_INFO WHERE ORGAN_ID='1' ";
    $SQL .= " UNION  ";
    $SQL .= " SELECT A.ORGAN_ID, A.TREE_DEPTH, A.GROUP_ID, A.GROUP_NAME, IFNULL(B.RTU_ID,0) RTU_ID, B.RTU_NAME, B.AREA_CODE, 0 PARENT_ID, TREE_PATH  ";
    $SQL .= " FROM GROUP_INFO A, RTU_INFO B, RTU_GROUP C  ";
    $SQL .= " WHERE C.ORGAN_ID='1'  ";
    $SQL .= "   AND A.GROUP_ID=C.GROUP_ID AND B.RTU_ID=C.RTU_ID AND A.ORGAN_ID=B.ORGAN_ID  ";
    $SQL .= "   AND A.GROUP_ID IN (SELECT GROUP_ID FROM RTU_GROUP WHERE RTU_ID IN (".$_COOKIE['keyTosRtuID'].") ) AND B.RTU_TYPE = 'B00' ORDER BY TREE_PATH, RTU_ID) A  ";
    $SQL .= "       LEFT JOIN (SELECT RTU_ID USER_RTU, '1' USER_RIGHT_X FROM RTU_INFO WHERE ORGAN_ID='1' AND RTU_TYPE = 'B00' AND RTU_ID IN (".$_COOKIE['keyTosRtuID'].") ORDER BY SORT_FLAG) B ";
    $SQL .= "                 ON A.RTU_ID=B.USER_RTU ";

        $rs = $this->DB->execute($SQL);

        for($i=0; $i<$this->DB->NUM_ROW(); $i++){
            $this->GROUP_NAME[$i]           = iconv('EUCKR', 'UTF-8', $rs[$i]['GROUP_NAME']);
            $this->RTU_NAME[$i]         = iconv('EUCKR', 'UTF-8', $rs[$i]['RTU_NAME']);
            $this->RTU_ID[$i]               = $rs[$i]['RTU_ID'];
            $this->RTU_TYPE[$i]         = $rs[$i]['RTU_TYPE'];
        }
        unset($rs);
        $this->rsCnt = $i;
        $this->DB->parseFree();
    }


    function getRtuInfo($localcode=null) {
        if(SYSTEM_TYPE=="DISOS")    $this->getDisosRtuInfo($localcode);
        else                        $this->getDivasRtuInfo($localcode);
    }

/*
  * Disos RTU 정보
  */
    function getDisosRtuInfo($localcode=null) {

        unset($this->AREA_CODE,$this->RTU_NAME,$this->RTU_TYPE,$this->MODEL_TYPE,$this->IP_ADDRESS,$this->FLOW_DANGER,$this->FLOW_WARNING,$this->LINE_TYPE,$this->PORT,$this->BAUD_RATE,$this->AVR_TYPE,$this->FONT_IDX,$this->SORT_FLAG,$this->CALL_LAST,$this->MODEL_ID, $this->rsCnt);

            Switch($this->SENSERTYPE) {


                Case '0'  : $w_sensertype = "SENSOR_TYPE IN (0,3)"; break;
                Case '1'  : $w_sensertype = "SENSOR_TYPE IN (1)"; break;
                Case '2'  : $w_sensertype = "SENSOR_TYPE IN (2)"; break;
                Case '3'  : $w_sensertype = "SENSOR_TYPE IN (0,3)"; break;
                default: $w_sensertype = "SENSOR_TYPE IN (0)"; break;
            }


            if($this->SENSERTYPE!==null && $this->AVRCHECK!==null) {
                $sqlWhere = " where (" . $w_sensertype . ") and IS_AVERAGE = $this->AVRCHECK  ";
            }elseif($this->SENSERTYPE!==null) {
                $sqlWhere = " where " . $w_sensertype;
            }


    //AWS 하나지역 선택
        if($localcode!==null){
            $sqlWhere = " where AREA_CODE = '$localcode' ";
        }



        $sql = "SELECT  RTU_ID, AREA_CODE, RTU_NAME, CALL_LAST, SENSOR_TYPE as RTU_TYPE, FLOW_WARNING as WARNING_SMS, FLOW_DANGER as DANGER_SMS, SENSOR_TYPE,  AVR_TYPE as IS_AVERAGE  FROM RTU_INFO ";
        $sql .= $sqlWhere;


//echo $sql;
//echo "<br>";

        $rs = $this->DB->execute($sql);

        for($i=0; $i<$this->DB->NUM_ROW(); $i++){
            $this->AREA_CODE[$i]         = $rs[$i]['AREA_CODE'];
            $this->RTU_NAME[$i]        = $rs[$i]['RTU_NAME'];
            $this->RTU_TYPE[$i]        = $rs[$i]['RTU_TYPE'];
            $this->MODEL_TYPE[$i]        = $rs[$i]['MODEL_TYPE'];
            $this->IP_ADDRESS[$i]        = $rs[$i]['IP_ADDRESS'];
            $this->BASE_RISKLEVEL2[$i] = $rs[$i]['BASE_RISKLEVEL2'];
            $this->BASE_RISKLEVEL1[$i] = $rs[$i]['BASE_RISKLEVEL1'];
            $this->LINE_TYPE[$i]         = $rs[$i]['LINE_TYPE'];
            $this->PORT[$i]            = $rs[$i]['PORT'];
            $this->AVR_TYPE[$i]        = $rs[$i]['IS_AVERAGE'];
            $this->FONT_IDX[$i]        = $rs[$i]['FONT_IDX'];
            $this->SORT_FLAG[$i]         = $rs[$i]['SORT_FLAG'];
            $this->CALL_LAST[$i]         = $rs[$i]['CALL_LAST'];
        }

        unset($rs);
        $this->rsCnt = $i;
        $this->DB->parseFree();
    }


 /*
  * Divas RTU 정보
  */
    function getDivasRtuInfo($localcode=null) {

        if(empty($_COOKIE['keyOrganID'])) $organid = 1;
        else                              $organid = $_COOKIE['keyOrganID'];

        unset($this->AREA_CODE,$this->RTU_NAME,$this->RTU_TYPE,$this->MODEL_TYPE,$this->IP_ADDRESS,$this->FLOW_DANGER,$this->FLOW_WARNING,$this->LINE_TYPE,$this->PORT,$this->BAUD_RATE,$this->AVR_TYPE,$this->FONT_IDX,$this->SORT_FLAG,$this->CALL_LAST,$this->MODEL_ID, $this->rsCnt);
        if($localcode!==null){
            $areacodeWhere = " and AREA_CODE = '$localcode' ";
        }


            /* 환경정보 *******************************************
                RTU_TYPE    CHAR(3)     NO  UNI         "장비 구분
                B00:방송장비
                A00:AWS
                R00:강우량계
                F00:수위계
                RF0:강우수위계
                F10:수위댐자료
                S00:적설계"

                    센서 구분(RTU_SENSER)
                    0 :강우/RAIN
                    1 :수위/FLOW
                    2 :적설/SNOW
                    A :기압/ATMO-spheric
                    T :기온/TEMP-erature
                    W :풍향풍속/WIND
                    H :습도/HUMI-dity
                    R :일사/RADI-ation
                    S :일조/SUNS-hine

            */


            Switch($this->SENSERTYPE) {

             	//Case '0'  : $w_sensertype = "0"; $w_rtutype = "'R00','RF0'"; break;
                //Case '1'  : $w_sensertype = "1"; $w_rtutype = "'R00','RF0','F00'"; break;
                Case '0'  : $w_sensertype = "0"; $w_rtutype = "'R00','RF0','B00'"; break;
                Case '1'  : $w_sensertype = "1"; $w_rtutype = "'F00','RF0','B00'"; break;
                Case '2'  : $w_sensertype = "0"; $w_rtutype = "'A00'"; break;
//              Case 'T'  : $w_sensertype = "T"; $w_rtutype = "'A00'"; break;
//              Case 'W'  : $w_sensertype = "W"; $w_rtutype = "'A00'"; break;
//              Case 3  : $w_sensertype = "A"; $w_rtutype = "'B00','R00','RF0"; break;
//              Case 5  : $w_sensertype = "H"; break;
//              Case 6  : $w_sensertype = "R"; break;
//              Case 7  : $w_sensertype = "S"; break;
//              Case 8  : $w_sensertype = "T"; break;
//              Case 9  : $w_sensertype = "W"; break;

                default: $w_sensertype = "0"; break;
            }

            if($this->SENSERTYPE!==null && $this->AVRCHECK!==null) {
                $sqlWhere = " where (" . $w_sensertype . ") and IS_AVERAGE = $this->AVRCHECK  ";
            }elseif($this->SENSERTYPE!==null) {
                $sqlWhere = " where " . $w_sensertype;
            }


        //$sql = "select AREA_CODE, RTU_NAME, RTU_TYPE, MODEL_TYPE, IP_ADDRESS, FLOW_DANGER, FLOW_WARNING, LINE_TYPE, PORT, BAUD_RATE, AVR_TYPE, FONT_IDX, SORT_FLAG, CALL_LAST, MODEL_ID from RTU_INFO " . $sqlWhere . " order by SORT_FLAG ASC ";
        //$sql   = "        select AREA_CODE, RTU_NAME, COMBI_TYPE, MODEL_NO, CONNECTION_INFO, DANGER_SMS, WARNING_SMS, LINE_NO, PORT, BAUDRATE, SORT_FLAG, CALL_LAST, MODEL_NO  ";
        //$sql  .= "        from RTU_INFO   ";
        //$sql  .= $sqlWhere;

    $sql   = "  SELECT  A.RTU_ID, A.AREA_CODE, A.RTU_NAME, A.CALL_LAST, A.RTU_TYPE, A.WARNING_SMS, A.DANGER_SMS, B.SENSOR_TYPE, B.BASE_RISKLEVEL1, B.BASE_RISKLEVEL2, B.IS_AVERAGE ";
    $sql  .= "  FROM    RTU_INFO A, RTU_SENSOR B                                                                                                                              ";
    $sql  .= "  WHERE   A.RTU_ID=B.RTU_ID                                                                                                               ";
        $sql  .= "      AND A.RTU_TYPE IN (". $w_rtutype .")                                                                                                ";
        $sql  .= "      AND B.SENSOR_TYPE IN ('". $w_sensertype ."')                                                                                        ";
    $sql  .= "      AND A.ORGAN_ID=" . $organid . "";
    $sql  .= $areacodeWhere . "";
        $sql  .= "      order by SORT_FLAG ASC";


//B00:방송장비
//A00:AWS
//R00:강우량계
//F00:수위계
//RF0:강우수위계
//F10:수위댐자료
//S00:적설계"

// echo $sql;
//exit;
//echo "<br>";

        $rs = $this->DB->execute($sql);

        for($i=0; $i<$this->DB->NUM_ROW(); $i++){
            $this->AREA_CODE[$i]         = $rs[$i]['AREA_CODE'];
            $this->RTU_NAME[$i]        = $rs[$i]['RTU_NAME'];
            $this->RTU_TYPE[$i]        = $rs[$i]['RTU_TYPE'];
            $this->MODEL_TYPE[$i]        = $rs[$i]['MODEL_TYPE'];
            $this->IP_ADDRESS[$i]        = $rs[$i]['IP_ADDRESS'];
            $this->BASE_RISKLEVEL2[$i] = $rs[$i]['BASE_RISKLEVEL2'];
            $this->BASE_RISKLEVEL1[$i] = $rs[$i]['BASE_RISKLEVEL1'];
            $this->LINE_TYPE[$i]         = $rs[$i]['LINE_TYPE'];
            $this->PORT[$i]            = $rs[$i]['PORT'];
            $this->AVR_TYPE[$i]        = $rs[$i]['IS_AVERAGE'];
            $this->FONT_IDX[$i]        = $rs[$i]['FONT_IDX'];
            $this->SORT_FLAG[$i]         = $rs[$i]['SORT_FLAG'];
            $this->CALL_LAST[$i]         = $rs[$i]['CALL_LAST'];
        }

        unset($rs);
        $this->rsCnt = $i;
        $this->DB->parseFree();
    }
    
    // rtu_name
    function getRtuName($area_code=null) {
    	$sql = " SELECT RTU_NAME FROM rtu_info WHERE area_code = '".$area_code."' ";
    	$rs = $this->DB->execute($sql);
    	$this->RTU_NAME = $rs[0]['RTU_NAME'];
    }

    // rtu_name and level
    function getRtuNameAndLevel($area_code=null) {
    	$sql = " SELECT A.RTU_NAME, ifnull(B.BASE_RISKLEVEL1, '-') as level1, ifnull(B.BASE_RISKLEVEL2, '-') as level2, 
                ifnull(B.BASE_RISKLEVEL3, '-') as level3, ifnull(B.BASE_RISKLEVEL4, '-') as level4, ifnull(B.BASE_RISKLEVEL5, '-')  as level5
                FROM rtu_info AS A
                LEFT JOIN RTU_SENSOR AS B ON A.RTU_ID = B.RTU_ID 
                WHERE A.area_code = '".$area_code." '
                AND B.SENSOR_TYPE IN ('1', 'DP') ";
         
    	$rs = $this->DB->execute($sql);
    	$this->RTU_NAME = $rs[0]['RTU_NAME'];
    	$this->level1 = $rs[0]['level1']*$this->getCalc;
    	$this->level2 = $rs[0]['level2']*$this->getCalc;
    	$this->level3 = $rs[0]['level3']*$this->getCalc;
    	$this->level4 = $rs[0]['level4']*$this->getCalc;
    	$this->level5 = $rs[0]['level5']*$this->getCalc;
    }

    /* 쿼리실행 */
    public function exe_Query($sql) {

        $this->DB->execute($sql);
        $this->DB->parseFree();
    }

}//End Class

?>
