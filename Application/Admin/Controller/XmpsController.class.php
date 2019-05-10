<?php
namespace Admin\Controller;
use Think\Controller;
class XmpsController extends BaseController {

    /**
     * 专家打分页面
     */
    public function index(){
        $this->addLog('','用户访问日志','','访问项目评审','成功');
        $model = M('xmps_xmrelation');

        $this->assign("offset",I("get.offset"));
        $this->assign("offset",I("get.offset"));
        $relationdata = $model
            ->alias('t')
            ->join('left join xmps_xm m on m.xm_id=t.xr_xm_id')
            ->where("xr_user_id='" . session("user_id") . "' and xr_status='进行中' and m.xm_status!='删除' and m.xm_class='".session('classid')."'")
            ->count();
        if($relationdata>0){
            $this->display('score');
        }else{
            $this->display('index');
        }
    }

    /**
     * 专家打分/投票页面
     */
    public function indexold(){
        $tab = I('get.tab','score');
        $this->addLog('','用户访问日志','','访问项目评审','成功');
        $this->assign("offset",I("get.offset"));
        $this->assign("limit",I("get.limit"));
        $model = M('xmps_xmrelation');
        $relationdata = $model
            ->alias('t')
            ->join('left join xmps_xm m on m.xm_id=t.xr_xm_id')
            ->where("xr_user_id='" . session("user_id") . "' and xr_status='进行中' and m.xm_status!='删除' and m.xm_class='".session('classid')."'")
            ->count();
        // 获取投票数量和状态信息
        $class = session('classid');
        //if(empty($class)){
        //    echo "<script>top.location.href='".U('Admin/Index/index')."';</script>";die;
        //}
        $Round = 0; // 当前投票进行的轮次
        $roundInfo = M('votesetting')->where("class = '".$class."'")->select();//根据分组获得投票轮次信息
        $roundInfos = [];
        if($roundInfo){//如果有轮次信息
            foreach($roundInfo as $key=>$val){
                if($val['status'] == 1){//状态为开启，则赋值当前轮
                    $Round = $val['round'];
                }
                $roundInfos[$val['round']] = $val;//赋值该分组下的轮次信息，以轮次作为Key值
            }
        }
        // 查已投票数,本轮投票专家是否提交
        $votestatus = '';
        for($i=1;$i<4;$i++){
            if(!isset($roundInfos[$i])){//轮次为空 123
                $roundInfos[$i]['maxnum'] = ' ';
            }

            $vote = 'vote'.$i;
            $num = M('xmps_xm x')->join('xmps_xmrelation r on r.xr_xm_id=x.xm_id')->where("xm_class = '".$class."' and ".$vote." = 1 and xr_user_id='" . session("user_id") . "'")->count();
            $roundInfos[$i]['votenum'] = $num;
            if(($Round!=0) && ($i == $Round))
			{
                $voteroundstatus = 'vote'.$Round.'status';
                $res = M('xmps_xm x')->field("distinct $voteroundstatus")->join('xmps_xmrelation r on r.xr_xm_id=x.xm_id')->where("xm_class = '".$class."' and xr_user_id='" . session("user_id") . "'")->find();
                $votestatus = $res[$voteroundstatus];
			}
        }

//        print_r($votestatus);die;
        $this->assign('tab',$tab);
        $this->assign('Round',$Round);
        $this->assign('VotesSatus',$votestatus);
        $this->assign('roundInfo',json_encode($roundInfos));
        if($relationdata>0){
            $this->display('score');
        }else{
            $this->display('index');
        }
    }

 

    /**
     * 获取列表
     */
    public function getData(){
        $queryParam = json_decode(file_get_contents( "php://input"), true);
        $where = [];
        $where['xm_status'] = ['neq','删除'];
        $where['xm_class']  =['eq',session('classid')];
        $where['xr_status'] = ['eq',$queryParam['xr_status']];
		
        $where['xr_user_id'] = array('eq' ,session("user_id"));
        $model = M('xmps_xm');
        $data = $model->field('xm_id,xm_ordernum,xm_tmfs,xm_code,ishuibi,xm_name,ps_ql,ps_jz,ps_cx,vote4,xm_company,xm_createuser,xm_class,xm_year,xm_oldfenzu,xm_oldrank,xm_oldscore,xm_oldcommand,xr_id,xr_status,ps_zz,ps_total,xm_type,xm_group')
                    ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
                    ->where($where)
                    ->order($queryParam['sort']." ".$queryParam['sortOrder'])
                    ->limit($queryParam['offset'], $queryParam['limit'])
                    ->select();
//        echo $model->_sql();die;
        $count = $model->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')->where($where)->count();
        echo json_encode(array( 'total' => $count,'rows' => $data));
    }
    public function marking(){
        $id=I("get.id");
        $model = M('xmps_xm');
        $data = $model->field('xm_id,xm_code,xm_name,xm_company,xm_createuser,xr_id,ps_ql,ps_jz,ps_cx,ps_zz,ps_detail,ps_total')
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->where("xr_id='".$id."'")
            ->find();
    
        $this->assign("data",$data);
        $this->assign("offset",I("get.offset"));
        $this->assign("limit",I("get.limit"));
        $this->display();
    }
    public function showmarking(){
        $id=I("get.id");
        $model = M('xmps_xm');
        $data = $model->field('xm_id,xm_code,xm_name,xm_company,xm_createuser,xr_id,ps_ql,ps_jz,ps_cx,ps_zz,ps_detail,ps_total')
            ->join('xmps_xmrelation on xr_xm_id=xmps_xm.xm_id')
            ->where("xr_id='".$id."'")
            ->find();
//        $data["ps_detail"]=str_replace("$","\n",$data["ps_detail"]);
        $this->assign("data",$data);
        $this->assign("offset",I("get.offset"));
        $this->assign("limit",I("get.limit"));
        $this->display();
    }

    public function saveps(){
        $data=I("post.");
        foreach($data as $key=>$d) {
            if ($d == "")
                $data[$key] = null;
        }
        $data["ps_total"]=$data["ps_ql"]+$data["ps_jz"]+$data["ps_cx"];
        $data["ps_time"]=time();
        try {
            $model = M('xmps_xmrelation');
            $model->where("xr_id='" . $data["xr_id"] . "'")->save($data);
            echo "ok";
        }catch (Exception $e){
            echo "error";
        }
    }

    public function saveScore(){
        $data = I("post.data");
//        dump($data);
        $M = M('xmps_xmrelation');
        $res = $M->where($data)->count();
        if($res>0){
            exit(makeStandResult(0,'数据已保存'));
        }
        if(($data['ps_ql'] === '') && ($data['ps_jz'] === '') && ($data['ps_cx'] === '') && ($data['vote4'] === '')){
            $data['ps_ql'] = null;
            $data['ps_jz'] = null;
            $data['ps_cx'] = null;
            $data['vote4'] = null;
        }
        $re = $M->where("xr_id='".$data['xr_id']."'")->save($data);
        // echo $M->_sql();die;
        if($re!=false){
            exit(makeStandResult(0,'保存成功'));
        }
    }

    public function quxiaohuibi(){

    }

    public function panduanpswancheng()
    {
        $model = M('xmps_xmrelation');
        $relationdata = $model
            ->alias('t')
            ->join('left join xmps_xm m on m.xm_id=t.xr_xm_id')
            ->where("xr_user_id='" . session("user_id") . "' and xr_status='进行中' and m.xm_status!='删除' and m.xm_class='".session('classid')."'")
            ->select();
        $data = array();
        $str = "";
        foreach ($relationdata as $rd) {
            if($rd['ishuibi']!='1'){
                if ($rd["ps_ql"] == "" || $rd["ps_jz"] == "" || $rd["ps_cx"] == "") {
                    $str .='<li>'.$rd['xm_code'] . '</li>';
                }
            }
        }
        $str = rtrim($str, ',');
        if ($str != "") {
            echo '<p>以下项目尚未评审完毕，请评审完毕后再提交</p><ul>'.$str ."</ul>";
            die;
        }
        echo "ok";
    }
    public function savepswancheng()
    {
        $model = M('xmps_xmrelation');
        $model->startTrans();
        try {
            $relationdata = $model
                ->alias('t')
                ->join('left join xmps_xm m on m.xm_id=t.xr_xm_id')
                ->where("xr_user_id='" . session("user_id") . "' and xr_status='进行中' and m.xm_status!='删除' and m.xm_class='".session('classid')."'")
                ->select();
            foreach ($relationdata as $rd) {
                $data["xr_status"] = "完成";
                $xr_id = $rd["xr_id"];
                $model->where("xr_id='" . $xr_id . "'")->save($data);
                $xmid=$rd["xr_xm_id"];
                $xmtotal=$model->where("xr_xm_id='".$xmid."' and xr_status='完成' and ishuibi=0 ")->order("ps_total")->select();
                $xmcount=count($xmtotal);
                if($xmcount>2) {
                    unset($xmtotal[0]);
                    unset($xmtotal[$xmcount - 1]);
                    $total = 0;
                    foreach ($xmtotal as $t) {
                        $total += intval($t["ps_total"]);
                    }
                    $model->where("xr_xm_id='".$xmid."'")->setField("avgvalue",  number_format($total / ($xmcount - 2),3, '.', ''));
                }
                $ps_detail = $model->field('vote4')->where("xr_xm_id='".$xmid."' and xr_status='完成' and ishuibi=0 ")->order('vote4 asc')->select();
                $ps_detail = removeArrKey($ps_detail,'vote4',false);
                $ps_detail = implode('',$ps_detail);
                if(!empty($ps_detail)){
                    $model->where("xr_xm_id='".$xmid."'")->setField("ps_detail",  $ps_detail); 
                }
            }
            $model->commit();
            echo "ok";
        } catch (Exception $e) {
            $model->rollback();
            echo "error";
        }
    }

    public function showfile()
    {
        $xm_name=I("get.xm_name");
        $filepath=C("xmfilepath");
        $xm_name=iconv('utf-8','gb2312',$xm_name);
        $html = file_get_contents($filepath . $xm_name);
        //下载xml
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Accept-Length:" . strlen($html));
        header("Content-Disposition:attachment;filename=" . $xm_name);
        echo $html;
        die;
    }

    public function listindex()
    {
        $xm_id=I("get.id");
        $model = M('xmps_xm');
        $xmdata=$model->where("xm_id='".$xm_id."'")->find();
        $file = '../../Public/'. C("xmfilepath")."/".$xmdata["xm_code"]."+".$xmdata["xm_company"]."+".$xmdata["xm_createuser"].".pdf";
        $this->assign('file',$file);
        $this->assign('showlable', $xmdata["xm_createuser"]."(".$xmdata["xm_company"].")".$xmdata["xm_code"]."_".$xmdata["xm_name"]);
        $this->display();
    }
    /**
     * 保存设置的投票
     */
    public function setVoteData()
    {
//        print_r(I('post.'));die;
        $voteData = I("post.voteData");
        $round    = I("post.round",'0');
        $type     = I("post.type");
        if($round == 0) exit(makeStandResult(1,'参数缺失，请重试'));

        // 查询投票是否还在当前轮次
        $class = session('classid');
        $nowround = 0; // 当前投票进行的轮次
        $roundInfo = M('votesetting')->where("class = '".$class."'")->select();
        if($roundInfo){
            foreach($roundInfo as $key=>$val){
                if($val['status'] == 1){
                    $nowround = $val['round'];
                }
            }
        }
        if($nowround != $round) exit(makeStandResult(1,'当前投票已结束，请刷新页面'));
        $voteround = 'vote'.$round;
        // 投票数是否超出最大数
        $maxnum = M('votesetting')->where("class = '".$class."' and round = '".$round."' and status =1")->getField('maxnum');
        $totalvotenum = 0;
        foreach($voteData as $key=>$val){
            $voteres  = $val[$voteround];
            if($voteres == '1') $totalvotenum++;
        }
        if(intval($totalvotenum) > intval($maxnum)) exit(makeStandResult(1,'投票数已超过最大投票数，请修改！'));
        $Model = M("xmps_xmrelation");
        try{
            $Model->startTrans();
            $votestatus = 'vote'.$round.'status';
//            echo $votestatus;die;
            foreach($voteData as $key=>$val){
                $voteres  = $val[$voteround];
                $data     = [];
                $xr_id    = $val['xr_id'];
                if($voteres != '-1'){
                    if($voteres){
                        $data[$voteround] = 1;
                    }else if($voteres === '0'){
                        $data[$voteround] = 0;
                    }else{
                        $data[$voteround] = '-2';
                    }
                }
                if($type == 'submit'){
                    $data[$votestatus] = '已完成';
                }
                if(!empty($data)){
                    $Model->where("xr_id = '".$xr_id."'")->setField($data);
//                    echo $Model->_sql();die;
                }
            }
            $Model->commit();
            exit(makeStandResult(0,'保存成功'));
        }catch (Exception $e){
            $Model->rollback();
            exit(makeStandResult(1,'保存失败:$e'));
        }
    }

    public function getVoteData()
    {
        $where['xm_status']=['neq','删除'];
        $where['xm_class']=['eq',session('classid')];
        $where['xr_status']=['eq','完成'];

        $where['xr_user_id'] = array('eq' ,session("user_id"));
        $model = M('xmps_xm x');
        $data = $model->field('xm_id,xm_ordernum,xm_tmfs,xm_code,ishuibi,xm_name,ps_ql,ps_jz,ps_cx,xm_company,xm_createuser,xm_class,xm_year,xm_oldfenzu,xm_oldrank,xm_oldscore,xm_oldcommand,xr_id,xr_status,ps_zz,ps_total,vote1,vote2,vote3,vote1option,vote2option,vote3option,avgvalue,vote1status,vote2status,vote3status')
            ->join('xmps_xmrelation r on r.xr_xm_id=x.xm_id')
            ->where($where)
            ->order("avgvalue desc,ps_total desc")
            ->select();
//        if($data){
//            foreach($data as $key=>$val){
//                $info = '项目编号：'.$val['xm_code']."<br/>";
//                $info .= '项目名称：'.$val['xm_name']."<br/>";
//                $info .= '依托单位：'.$val['xm_company']."<br/>";
//                $info .= '申请人：'.$val['xm_createuser']."<br/>";
//                $info .= '推荐方式：'.$val['xm_tmfs']."<br/>";
//                $data[$key]['xm_info'] = $info;
//            }
//        }
        $count = $model->join('xmps_xmrelation on xr_xm_id=x.xm_id')->where($where)->count();
        $this->ajaxReturn(array( 'total' => $count,'rows' => $data));
    }

}