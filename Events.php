<?php 
class Ack_Action_Events extends Ack_Action {
    public $publicAction = '*';
    private $not_need_login = array('gameprogress');
	private $key = 'hao.game.pwd';
		
    public function _empty()
    {
        $page = strtolower(ACTION_NAME);
        $tpl = TPL_PATH.THEME_NAME.'/events/'.$page.'.html';
        if (!file_exists($tpl)) {
            $this->redirect('/404');
        }
        $this->display();
    }

    public function game2048()
    {
        $do = $this->getKey('do');
        if ($this->uid <= 0 && $do != 'ranklist') {
            if ($do != 'index.htm')
                $this->error('用户未登录或会话已经过期');
            $this->assign('data', array('score'=>0,'username'=>'','avatar'=>'','isLogin'=>'false'));
            return $this->display();
        }

        $gameCode = '2048';

        $time = time();
        $Game = M('games');

        $data = array('score'=>0);
        if ($this->uid > 0) {
            $map = array('game'=>$gameCode);
            $map['uid'] = $this->uid;

            $data = $Game->where($map)->find();
            if ($data === false) {
                $this->error('系统出错，请重试！');
            }

            if (empty($data)) {
                $data = array();
                $data['score'] = 0;
                $data['addtime'] = $time;
                $data['uid'] = $this->uid;
                $data['game'] = $gameCode;
                $res = $Game->add($data);
                if (!$res) {
                    $this->error('系统忙，请稍后重试！');
                }
            }
        }

        if ($data['score'] <= 0) {
            $data['rank'] = 0;
        } else {
            $data['rank'] = 0;
            $cmap = array('game'=>$gameCode);
            $cmap['score'] = array('gt', $data['score']);
            $total = $Game->where($cmap)->count();
            $data['rank'] = $total + 1;
        }

        if ($do == 'ranklist') {
            // 排行榜
            $lmap = array('game'=>$gameCode);
            $lmap['score'] = array('neq', 0);
            $order = 'score desc';
            $limit = 10;
            $list = $Game->where($lmap)->order($order)->limit($limit)->select();
            if ($list === false)
                $this->error('系统忙，请重试！');
            if (!empty($list)) {
                $uids = array();
                foreach ($list as $k=>$row) {
                    $uids[] = $row['uid'];
                }
                $User = M('user');
                $umap = array();
                $umap['uid'] = array('in', $uids);
                $users = $User->field('uid,uname')->where($umap)->select();
                $usermap = array();
                foreach ($users as $v) {
                    $usermap[$v['uid']] = $v['uname'];
                }

                $rank = 0;
                foreach ($list as $k=>$row) {
                    ++ $rank;
                    $list[$k]['rank'] = $rank;
                    $list[$k]['username'] = $usermap[$row['uid']];
                }
            }
            $data = array(
                'user'=>array('rank'=>$data['rank'], 'score'=>$data['score']),
                'list'=>$list,
            );
            $this->ajaxReturn($data);
        }

        if ($do == 'userscore') {
            // 获取积分
            $data = array(
                'username'=>$this->user['uname'],
                'score'=>$data['score'],
            );
            $this->ajaxReturn($data);

        } else if ($do == 'savescore') {
            // 保存积分
            if (empty($_POST['score']) || empty($_POST['key']))
                $this->error('参数错误');
            $score = intval($_POST['score']);
            if ($score <= $data['score'])
                $this->success('无需保存');

            $key = date('Y-m-d H:i', $time).$this->uid.$_SERVER['HTTP_USER_AGENT'].md5($score);
            if (strlen($_POST['key']) != 64 || md5($key).md5(strrev($key)) != $_POST['key'])
                $this->error('非法数据:'.$key);

            $data = array();
            $data['score'] = $score;
            $data['uptime'] = $time;
            $res = $Game->where($map)->save($data);
            if ($res)
                $this->success('保存成功');
            else
                $this->error('保存失败');
        }

        $data['avatar'] = $this->user['avatar_url'];
        $data['username'] = $this->user['uname'];
        $data['isLogin'] = 'true';

        $this->assign('data', $data);

        $this->display();
    }


    public function worldcup()
	{		
		$do = $this->getParam('do');
						
		if (!empty($do)) {
			!$this->uid && !in_array($do, $this->not_need_login) && $this->ajaxReturn('请先登录', true, 0);
						
			//冠军   四强
			if (in_array($do, array('champion', 'topfour'))) {
				$D_WORLDCUP = D('worldcup');				
				$worldcupinfo = $D_WORLDCUP->where(array('uid'=>$this->uid))->find();				
			}
						
			//每场比赛的获胜球队    比分
			if (in_array($do, array('gamewin', 'gamescore'))) {
				$D_WORLDCUP_GAME = D('worldcup_game');
				empty($_POST['gameid']) && $this->ajaxReturn('参数错误', true, 0);
				$gameid = intval($_POST['gameid']);				
				$worldcup_game = $D_WORLDCUP_GAME->where(array('uid'=>$this->uid, 'gameid'=>$gameid))->find();
			}			
			if ($do == 'champion') {				
				!empty($worldcupinfo['champion']) && $this->ajaxReturn('不能重复竞猜', true, 0);
				
				$data['champion'] = intval($_POST['id']);
				empty($data['champion']) && $this->ajaxReturn('参数错误', true, 0);					
										
			} else if ($do == 'topfour') {
				!empty($worldcupinfo['topfour']) && $this->ajaxReturn('不能重复竞猜', true, 0);
				
				$topfour = $this->getParam('id');
				$topfour = explode('#', trim($topfour, '#'));
				count($topfour) != 4 && $this->ajaxReturn('参数错误', true, 0);
				
				$data['topfour'] = implode('#', $topfour);	
											
			} else if ($do == 'gamewin') {
				!empty($worldcup_game['win']) && $this->ajaxReturn('不能重复竞猜', true, 0);
				
				!isset($_POST['teamid']) && $this->ajaxReturn('参数错误', true, 0);
				
				$data['win'] = intval($_POST['teamid']);	
				$data['win'] == 0 && $data['win'] = 100;			
				
			} else if ($do == 'gamescore') {
				!empty($worldcup_game['score']) && $this->ajaxReturn('不能重复竞猜', true, 0);
				
				$score = explode(':', $_POST['score']);
				count($score) != 2 && $this->ajaxReturn('参数错误', true, 0);
				
				$data['score'] = intval($score[0]) . ':' . intval($score[1]);
				
			} else if ($do == 'gameprogress') {				
				!preg_match('/^[\d#]+$/', $_POST['game']) && $this->ajaxReturn('参数错误', true, 0);
				
				$game = explode('#', trim($_POST['game']));
				
				$D_WORLDCUP_GAME = D('worldcup_game');
				
				$progressList = array();
				foreach ($game as $gameid) {
					$res = $D_WORLDCUP_GAME->where(array('gameid'=>$gameid))->field('win')->select();
					if ($res) {
						$arr = array();
						foreach ($res as $win) {
							array_push($arr, $win['win']);
						}
						$progressList[$gameid] = $arr;
					}
				}
				$this->ajaxReturn($progressList);
			}
			
			if (in_array($do, array('champion', 'topfour'))) {
				$data['uid'] = $this->uid;
				$data['uptime'] = time();
				if ($worldcupinfo)
					$res = $D_WORLDCUP->where(array('uid'=>$this->uid))->save($data);
				else
					$res = $D_WORLDCUP->add($data);
				
				if (!$res) {
					//$this->ajaxReturn($D_WORLDCUP->getError(), true, 0);
					$this->ajaxReturn('系统忙，稍候再试', true, 0);
				}
				$this->ajaxReturn();
			}
			
			if (in_array($do, array('gamewin', 'gamescore'))) {
				$data['uid'] = $this->uid;
				$data['gameid'] = $gameid;
				$data['uptime'] = time();
				if ($worldcup_game)
					$res = $D_WORLDCUP_GAME->where(array('uid'=>$this->uid, 'gameid'=>$gameid))->save($data);
				else 
					$res = $D_WORLDCUP_GAME->add($data);
				if (!$res) {
					$this->ajaxReturn('系统忙，稍候再试', true, 0);
				}
				$this->ajaxReturn();
			}
			
		} else {		
			$usergamescore = '';
			
			if ($this->uid > 0) {
				$D_WORLDCUP = D('worldcup');
				$worldcupinfo = $D_WORLDCUP->where(array('uid'=>$this->uid))->find();
				$this->assign('worldcupinfo', $worldcupinfo);	

				$D_WORLDCUP_GAME = D('worldcup_game');
				$usergamescore = $D_WORLDCUP_GAME->where(array('uid'=>$this->uid))->field('gameid,win,score')->select();	
			}

			$this->assign('usergamescore', json_encode($usergamescore));
			$this->assign('uid', $this->uid);
			$this->display();
		}
	}
	
	public function worldcupResult()
	{		
		if ($_POST['do'] && in_array($_POST['do'], array('search', 'download'))) {
			if (empty($_POST['key']) || $_POST['key'] != $this->key)
				$this->ajaxReturn('密钥错误', true, 0);
			
			if (empty($_POST['id']) || empty($_POST['type']))
				$this->ajaxReturn('参数错误', true, 0);
			
			if (in_array($_POST['type'], array('win', 'both'))) {
				empty($_POST['win']) && $this->ajaxReturn('参数错误', true, 0);
				$where['win'] = intval($_POST['win']);
			}
	
			if (in_array($_POST['type'], array('score', 'both'))) {
				(empty($_POST['score']) || !preg_match('/^\d+:\d+$/', $_POST['score'])) && $this->ajaxReturn('参数错误', true, 0);
				$where['score'] = $_POST['score'];
			}
			
			empty($where) && $this->ajaxReturn('参数错误', true, 0);
			
			$where['_logic'] = 'or';
			
			$map['gameid'] = intval($_POST['id']);
			$map['_complex'] = $where;		
			
			$D_WORLDCUP_GAME = D('worldcup_game');
			
			$res = $D_WORLDCUP_GAME->where($map)->field('uid, win, score, gameid')->select();			
				
			if ($res) {
				$downloadStr = '';
				foreach ($res as &$row) {
					$row['point'] = 0;
					$row['win'] == $_POST['win'] && $row['point'] += 5;
					$row['score'] == $_POST['score'] && $row['point'] += 200;
					
					$downloadStr .= $row['uid'] . ':' . $row['point'] . "\r\n";
				}
			}
			
			if ($_POST['do'] == 'download') {				
				$filename = $_POST['id'] . '.txt';
				header('Content-type: application/octet-stream');
				header('Accept-Ranges: bytes');
				header('Accept-Length: ' . strlen($downloadStr));
				header('Content-Disposition: attachment; filename=' . $filename);
				echo $downloadStr;
				exit;		
			}
			
			$this->ajaxReturn($res);
		}
				
		$this->display();	
	}

	public function yearMeetingApply()
	{
		static $fieldConfig = [
			'gender'	=>	[
				'w'	=>	'先生',
				'm'	=>	'女士'
			],
			'traffic'	=>	[
				'1'	=>	'飞机',
				'2'	=>	'动车',
				'3'	=>	'火车',
				'4'	=>	'汽车'	
			],
			'status'	=>	[
				'0'	=>	'已取消',
				'1'	=>	'申请成功',
				'10'	=>	'已确认',
				'20'	=>	'异常',
				'30'	=>	'已签到'
			]
		];	
		static $fieldValidator = [
			'realname'	=>	'/^[\x{4E00}-\x{9Fa5}]+$/u',
			'gender'	=>	'/^[w|m]{1}$/',
			'mobile'	=>	'/^[\d]{11}$/',
			'other_mobile'	=>	'/^([\d-]{11,15})?$/',
			'qq'	=>	'/^\d{3,13}$/',	
			'comefrom'	=>	'/^[\x{4E00}-\x{9Fa5}\s]+$/u',
			'traffic'	=>	'/^[\d]{1}$/',
			'certify'	=>	'/^[^\'\"]*$/'
		];

		$uid = $this->uid;

		$data = $_REQUEST;
		//$year = date('Y', time());
		$year = 2014;

		//操作值
		$do = $data['_do'];
		if (empty($do))
			$this->ajaxReturn('非法操作', true, 0);
		unset($data['_do']);

		//需要登录
		if (in_array($do, ['apply', 'cancel', 'info']))
		{
			if (!$uid)
				$this->ajaxReturn('请先登录', true, 0);
		}
		//需要密码
		if (in_array($do, ['list', 'confirm']))
		{
			$password = 'yqhbmpass'.$year;
			if (empty($data['password']) || $data['password'] != $password)
				$this->ajaxReturn('无权限查看或密码错误', true, 0);
			unset($data['password']);
		}

		$M = M('year_meeting_apply');

		//检查是否已经报名过
		$exist = function($uid) use ($M, $year)
		{
			$uid = intval($uid);
			return $M->where("uid=$uid and year='$year'")->find();	
		};
		$format = function($row) use ($fieldConfig)
		{
			$row['gender'] = $fieldConfig['gender'][$row['gender']];
			$row['traffic'] = $fieldConfig['traffic'][$row['traffic']];
			$row['status_text'] = $fieldConfig['status'][$row['status']];
			$row['time'] = $row['addtime'];
			$row['addtime'] = date('Y-m-d H:i', $row['addtime']);
			if (!empty($row['otherfields']))
				$row['otherfields'] = unserialize($row['otherfields']);
			return $row;
		};

		//申请
		if ($do == 'apply')
		{
			$otherfields = [];

			foreach ($data as $field=>$value)
			{
				if (!array_key_exists($field, $fieldValidator))
				{
					$otherfields[$field] = $data[$field];
					unset($data[$field]);
					continue;
				}
				if (!preg_match($fieldValidator[$field], $value))
					$this->ajaxReturn($field . '格式错误', true, 0);
			}
			$data['addtime'] = time();
			$data['status'] = 1;
			$data['year'] = $year;
			if (!empty($otherfields))
				$data['otherfields'] = serialize($otherfields);

			//修改
			if ($exist($uid))
			{
				if ($M->where("uid=$uid and year='$year'")->save($data))
				{
					return $this->ajaxReturn('修改成功', true);
				}
				else
				{
					return $this->ajaxReturn('修改失败', true, 0);
				}
			}
			//申请
			else
			{
				$data['uid'] = $uid;
				if ($M->add($data))	
				{
					return $this->ajaxReturn('报名成功', true);
				}
				else
				{
					return $this->ajaxReturn('报名失败', true, 0);
				}
			}	
		}

		//检查是否已经报名过
		if ($do == 'exist')
		{
			if (isset($data['uid']))	
				$uid = $data['uid'];
			if (empty($uid))
				$this->ajaxReturn('参数错误', true, 0);
			$info = $exist($uid);
			if (!$info)
				$this->ajaxReturn('未报名', true, 0);
			else if ($info['status'] == 1)
				$this->ajaxReturn('已经报名', true);
			else if ($info['status'] == 10)
				$this->ajaxReturn('已确认', true);
			else
				$this->ajaxReturn('报名已取消', true, 0);
		}

		//查看报名列表
		if ($do == 'list')
		{
			if (isset($data['_confirm']) and $data['_confirm'])
				$condition = 'y.status in (10, 30)';//已确认过的信息
			else if (isset($data['_signin']) and $data['_signin'])
				$condition = 'y.status=30';//已签到的信息
			else
				$condition = 'y.status in (1, 10, 30)';//申请过的 
			M('year_meeting_apply')->where('status=30 or uid=0')->delete();

			//vip等级搜索
			if (isset($data['_vip']))
				$condition .= ' and u.vip='.intval($data['_vip']);

			if (isset($data['_certify']))
				$condition .= ' and y.certify!=\'\'';

			//2014年度报名
			$condition .= " and y.year='$year'";

			if (isset($data['_order_field']) and isset($data['_order']) 
				and in_array($data['_order_field'], ['addtime', 'uid', 'status', 'traffic']) 
				and in_array($data['_order'], ['asc', 'desc'])
			) {
				$order = 'y.' . $data['_order_field'] . ' ' . $data['_order'];
			} else {
				$order = 'y.addtime desc';
			}

			$list = $M->alias('y')
						->join(C('DB_PREFIX').'user u on y.uid=u.uid', 'LEFT')
						->field('y.*, u.vip, u.realname urealname, u.umobile')
						->where($condition)
						->order($order);
			//分页
			if ($data['_limit'] and $data['_p'])
			{
				$p = intval($data['_p']);
				$limit = intval($data['_limit']);

				$list = $list->limit(($p-1)*$limit . ',' . $limit);
			}

			$list = $list->select();
			if (!$this->isAjax())
			{
				$this->outputsignin($list);
				exit();
			}

			$count = $M->alias('y')
						->join(C('DB_PREFIX').'user u on y.uid=u.uid', 'LEFT')
						->where($condition)->count();
			foreach ($list as &$row)
			{
				$row = $format($row);
			}
			$this->ajaxReturn([
				'list'	=>	$list,
				'count'	=>	$count
			]);
		}

		//取消报名
		if ($do == 'cancel')
		{
			if (!$exist($uid))
				$this->ajaxReturn('无需取消', true, 0);

			$uid = intval($uid);
			if ($M->where("uid=$uid and year='$year'")->save(['status' => 0]))
				$this->ajaxReturn('取消成功', true);
			else
				$this->ajaxReturn('取消失败，稍后再试', true, 0);
		}

		//获取用户报名信息
		if ($do == 'info')
		{
			$info = $exist($uid);
			if (!$info)
				$this->ajaxReturn('没有数据', true, 0);
			$this->ajaxReturn($format($info));
		}

		//确认报名资格
		if ($do == 'confirm')
		{
			$_uid = intval($data['uid']);
			$info = $exist($_uid);
			if (!$info)
				$this->ajaxReturn('数据不存在', true, 0);
			if ($M->where("uid=$_uid and year='$year'")->save(['status' => 10]))
				$this->ajaxReturn('确认成功', true);
			else
				$this->ajaxReturn('确认失败，稍后再试', true, 0);
		}

		//统计已确认报名数目
		if ($do == 'count')
		{
			$confirm_count = $M->where("year='$year' and status=10")->count();
			$this->ajaxReturn([
				'confirm_count'	=>	$confirm_count
			], true);
		}
		
		exit();
	}

	public function outputsignin($rows)
	{
		$gudonguids = [101361,108431,108982,100988,100824,100981,100351,100851,102376,102380,101028,114744,100822,106023,105369,106683,111542,100957,102274,103929,107955,111492,109666];
		$str = '<table style="width:80%; line-height:22px;">';
		$str .= '<tr style="text-align:left;"><th>用户ID</th><th>姓名</th><th>会员等级</th><th>手机号</th><th>签到</th><th>签到时间</th><th>来自</th></tr>';
		$sort = function($a, $b)
		{
			return $a['uid'] > $b['uid'];
		};
		usort($rows, $sort);
		foreach ($rows as $row)
		{
			$uid = '';
			$vip = '未知';
			if ($row['uid'])
			{
				$uid = $row['uid'];
				if (in_array($row['uid'], $gudonguids))
					$vip = '股东';
				if ($row['vip'] == 8)
					$vip = '白金会员';
				else
					$vip = '普通';
			}
			$str .= "<tr><td>{$uid}</td><td>{$row['realname']}</td><td>{$vip}</td><td>{$row['mobile']}</td><td>{$row['status_text']}</td><td>{$row['otherfields']['signin_time']}</td><td>{$row['comefrom']}</td></tr>";
		}
		$str .= '</table>';
		echo $str;
	}

	public function yearapplyemails()
	{
		if ($_REQUEST['pass'] != 'yqhbmpass2014')
			$this->ajaxReturn('无权限', true, 0);

		$gudonguids = [101361,108431,108982,100988,100824,100981,100351,100851,102376,102380,101028,114744,100822,106023,105369,106683,111542,100957,102274,103929,107955,111492,109666];

		$uids = '101361,108431,108982,100988,100824,100981,100351,100851,102376,102380,101028,114744,100822,106023,105369,106683,111542,100957,102274,103929,107955,111492,109666,101070,145727,126414,109515,110038,142618,124869,152303,108353,102651,105703,112262,102144,114589,120820,126667,101136,119668,124581,120726,110992,110680,122702,127284,114694,109481,109367,100830,104034,119807,147052,121238,119658,145883,145851,121170,103891,151775,124700,109573,105543,104232,125302,143142,113708,117883,113568,102875,120439,100665,148646,127003,109001,100647,104037,148034,125785,104801,124323,124575,117005,117980,145635,124604,125675,116444,111165,150975,139690,115202,123854,146099,150924,148450,118331,105135,126148,112286,108124,111307,124126,148578,102573,145532,114313,150802,150084,147236,126701,123024,113770,105395,113874,120629,120017,125266,127345,120161,108222,125231,116446,150710,115554,105759,109297,150538,117931,145895,128132,127310,100337,148176,108864,123122,148508,124521,100797,126657,111185,120023,108689,100026,102521,111045,102961,103658,124877,104410,103477';
		$rows = M('user')->where("uid in($uids)")->field('uid,uemail,vip')->select();
		$emails = [
			'gudong'	=>	[],
			'baijin'	=>	[],
			'normal'	=>	[]
		];
		foreach ($rows as $row)
		{
			if (!$row['uemail'])
				continue;
			if (in_array($row['uid'], $gudonguids))
			{
				$emails['gudong'][] = $row['uemail'];
				continue;
			}
			if ($row['vip'] == 8)
			{
				$emails['baijin'][] = $row['uemail'];
				continue;
			}
			$emails['normal'][] = $row['uemail'];
		}
		$this->ajaxReturn($emails);
	}
	
	/**
	 * 年会 - 微信签到
	 */
	public function signin()
	{
		//$year = date('Y', time());
		$year = 2014;
		$sendmsg = '您好，恭喜您已经签到成功！';
		$sendmsg2 = '您好，恭喜您已经签到成功！请到签到处领取金米一份。';
		$Model = M('year_meeting_apply');
		$baseUrl = 'https://m.yiqihao.com';
		$autoclose = true;

		//客户授权
		if (!isset($_REQUEST['code']) and isset($_REQUEST['_do']) and $_REQUEST['_do'] == 'auth')
		{
			$url = trim($baseUrl, '/') . '/events/signin';
			return Weixin::authorize($url);
		}

		//是否是股东或者白金会员
		$issu = function($uid, $vip)
		{
			$gudonguids = [101361,108431,108982,100988,100824,100981,100351,100851,102376,102380,101028,114744,100822,106023,105369,106683,111542,100957,102274,103929,107955,111492,109666];
			if (in_array($uid, $gudonguids) || $vip == 8)
				return true;
			return false;
		};

		//处理提交过来的签到表单
		if (isset($_REQUEST['_do']) and $_REQUEST['_do'] == 'signin')
		{
			$realname = $_REQUEST['realname'];
			$mobile = $_REQUEST['mobile'];

			if (!preg_match('/^[\x{4E00}-\x{9Fa5}]+$/u', $realname))
				$this->yearmeetinghint('姓名必须为中文');
			if (!preg_match('/^[\d_]{11,12}$/', $mobile))
				$this->yearmeetinghint('手机号格式不正确');

			$openid = Weixin::getSession('openid');
			if (empty($openid))
				$this->yearmeetinghint('请重新扫描二维码');

			//先查找uid
			$uid = 0;
			$user = M('user')->where("umobile='$mobile' and realname='$realname'")
					->field('uid,vip')->find();
			if ($user)
			{
				$uid = $user['uid'];
				//股东白金会员组
				if ($issu($uid, $user['vip']))
					$sendmsg = $sendmsg2;

				$condition = "uid=$uid and year='$year'";
				$user_yearmeetingapply = $Model->where($condition)->find();
				if ($user_yearmeetingapply)
				{
					$otherfields = unserialize($user_yearmeetingapply['otherfields']);
					if ($user_yearmeetingapply['status'] == 30)
						$this->yearmeetinghint('您已经在' . $otherfields['signin_time'] . '签到成功');

					$otherfields['signin_time'] = date('Y-m-d H:i');
					$otherfields = serialize($otherfields);

					if ($Model->where($condition)->save(['status'=>30, 'otherfields'=>$otherfields]))
					{
						Weixin::sendmsg($openid, $sendmsg);
						$this->yearmeetinghint($sendmsg);
					}
					else
					{
						$this->yearmeetinghint('签到失败');
					}
				}
			}

			//查找是否已报名
			$condition = "year='$year' and realname='$realname' and mobile='$mobile'";
			$user = $Model->where($condition)->find();
			if ($user)
			{
				$otherfields = unserialize($user['otherfields']);
				if ($user['status'] == 30)
				{
					$this->yearmeetinghint('您已经在' . $otherfields['signin_time'] . '签到成功');
				}
				$otherfields['signin_time'] = date('Y-m-d H:i');
				$otherfields = serialize($otherfields);
				if ($Model->where('id='.$user['id'])->save(['status'=>30, 'otherfields'=>$otherfields]))
				{
					Weixin::sendmsg($openid, $sendmsg);
					$this->yearmeetinghint($sendmsg);
				}
				else
				{
					$this->yearmeetinghint('签到失败');
				}
			}

			$data['uid'] = $uid;
			$data['realname'] = $realname;
			$data['mobile'] = $mobile;
			$data['year'] = $year;
			$data['status'] = 30;
			$otherfields['signin_time'] = date('Y-m-d H:i');
			$otherfields = serialize($otherfields);
			$data['otherfields'] = $otherfields;
			if ($Model->add($data))
			{
				Weixin::sendmsg($openid, $sendmsg);
				$this->yearmeetinghint($sendmsg);
			}
			else
			{
				$this->yearmeetinghint('签到失败');
			}
		}

		//获取用户授权信息
		$code = $_REQUEST['code'];
		Weixin::authAccessToken($code);

		$openid = Weixin::getSession('openid');

		//通过openid查找用户id
		$Open = M('open');
		$uid = $Open->where(array('openid'=>$openid, 'api'=>'weixin', 'isbind'=>1))->find();
		//没有查找到对应用户，则跳转到直接填写签到信息界面
		if (!$uid)
		{
			$url = trim($baseUrl, '/') . '/events/signinapply';
			header("Location:$url");
			return;
		}
		$uid = $uid['uid'];
		//股东白金会员组
		if ($issu($uid, $user['vip']))
			$sendmsg = $sendmsg2;

		$condition = "uid=$uid and year='$year'";
		$user_yearmeetingapply = $Model->where($condition)->find();
		if (!$user_yearmeetingapply)
		{
			//$this->error('数据错误');
			//没有报名数据 则跳转到填写信息的界面
			$url = trim($baseUrl, '/') . '/events/signinapply';
			header("Location:$url");
			return;
		}
		//更新状态
		$otherfields = unserialize($user_yearmeetingapply['otherfields']);
		if ($user_yearmeetingapply['status'] == 30)
		{
			$this->yearmeetinghint('您已经在' . $otherfields['signin_time'] . '签到成功');
		}
		$otherfields['signin_time'] = date('Y-m-d H:i');
		$otherfields = serialize($otherfields);

		if ($Model->where($condition)->save(['status'=>30, 'otherfields'=>$otherfields]))
		{
			Weixin::sendmsg($openid, $sendmsg);
			$this->yearmeetinghint($sendmsg);
		}
		else
		{
			$this->yearmeetinghint('签到失败');
		}
	}

	public function yearmeetinghint($msg)
	{
		$this->assign('msg', $msg);
		$this->display('signin_success');
	}

	private function uploadOne($uploadDir, $fileType = 'image', $maxSize = 1)
	{
        if (empty($_FILES))
            $this->error('请选择要上传的文件');
		$upload = new Ops_Upload();
		$allowExts = [
			'image'	=>	['jpg', 'jpeg', 'png']
		];
		$upload->allowExts = $allowExts[$fileType];
        $upload->maxSize = 1024*1024*$maxSize;
        $upload->savePath = PUBLIC_PATH . 'upload/' . ltrim($uploadDir, '/');
        $upload->saveRule = 'make_fid';
        $upload->hashType = '';
        $upload->toLower = true;

		$list = $upload->uploadOne($_FILES['file']);
		if (empty($list)) {
			$error = $upload->getError();
			$this->error(empty($error) ? '上传失败' : $error);
		}
		return $list;
	}

	/**
	 * 最佳投资人活动
	 */
	public function bestInvestor()
	{
		$_URL_ = $_GET['_URL_'];
		list($action, $id) = array_slice($_URL_, 2);

		/**
		 * upload-上传、list-投资人数据列表
		 * vote-投票
		 * votes-该选项下面的投票数据
		 * winner-胜利者
		 * myvotes-当前登录者投过票
		 */
		if (!in_array($action, ['upload', 'list', 'vote', 'votes', 'winner', 'myvotes']))
			$this->error('错误操作');

		if (in_array($action, ['upload', 'vote', 'myvotes']) and !$this->uid)
			$this->error('请先登录');

		$uid = $this->uid;
		$user = $this->user;
		$sign = date('Y');
		$M_BestInvestor = M('bestinvestor');
		$M_BestInvestorVote = M('bestinvestor_vote');
		$user_vote_num = 1;	//限制每个用户投票次数
		$winner_num = 6;	//获胜者人数
		$thumb = [
			'maxWidth'	=>	1000,
			'maxHeight'	=>	800,
		];

		//查找用户是否参与竞选
		$findOneByUid = function($uid) use ($M_BestInvestor, $sign) {
			return $M_BestInvestor->where("uid=$uid and sign='$sign'")->find();
		};
		//获取所有选项
		$findList = function($opts = []) use ($M_BestInvestor, $sign) {
			$p = isset($opts['p']) ? $opts['p'] : 1;
			$pageSize = isset($opts['pageSize']) ? $opts['pageSize'] : 20;
			$order = isset($opts['order']) ? $opts['order'] : 'id desc';
			$offset = ($p-1)*$pageSize;
			return $M_BestInvestor
						->alias('B')
						->join(C('DB_PREFIX').'user U on B.uid=U.uid', 'LEFT')
						->where("B.sign='$sign' and B.status=1")
						->field('B.*,U.uname')
						->limit("$offset,$pageSize")
						->order('B.'.$order)
						->select();
		};
		//获取当前用户投过的选项
		$findUserVotes = function($uid) use ($M_BestInvestorVote, $sign) {
			return $M_BestInvestorVote->where("uid=$uid and sign='$sign'")->select();
		};
		//判断用户是否已经投票过该选项
		$voteExistByBidUid = function($bid, $uid) use ($M_BestInvestorVote) {
			$bid = intval($bid);
			return $M_BestInvestorVote->where("bid=$bid and uid=$uid")->find();
		};
		//判断用户是否还能投票
		$canVoteByUid = function($uid) use ($M_BestInvestorVote, $sign, $user_vote_num) {
			$count = $M_BestInvestorVote->where("uid=$uid and sign='$sign'")->count();
			return $count < $user_vote_num;
		};
		//获取该选项的投票数据
		$findVotes = function($bid) use ($M_BestInvestorVote, $sign) {
			$bid = intval($bid);
			return $M_BestInvestorVote->where("bid=$bid and sign='$sign'")
					->order('id asc')
					->select();
		};
		//获取胜利者
		$findVinner = function($limit) use ($M_BestInvestor, $sign) {
			return $M_BestInvestor->alias('B')
						->join(C('DB_PREFIX').'user U on B.uid=U.uid', 'LEFT')
						->where("sign='$sign'")
						->field('B.vote,B.uid,U.uname')
						->limit($limit)
						->order('B.vote desc')
						->select();
		};
		//格式化投票选项
		$formatBestInvestor = function(&$data) {
			if (is_array($data)) {
				foreach ($data as &$row) {
					$row['datetime'] = date('Y-m-d H:i', $row['addtime']);
					if ($row['other_fields'])
						$row['other_fields'] = unserialize($row['other_fields']);
				}
			}
		};

		//上传照片
		if ($action == 'upload') {
			//if ($user['vip'] != 8)
			//	$this->error('只有白金会员才有权限');
			$info = Ops_Input::safeShow($_REQUEST['info']);
			if (empty($info) || strlen($info)<10)
				$this->error('内容过短');

			$dir = base_convert($uid%256,10,16);
			$uploadDir = 'user/'.$dir.'/'.$uid.'/bestinvestor/';
			$uploadInfo = $this->uploadOne($uploadDir);

			$filepath = $uploadInfo['savepath'] . $uploadInfo['savename'];
			$img = '/public/upload/' . $uploadDir . $uploadInfo['savename'];
			Ops_Image::thumb($filepath, $filepath, '', $thumb['maxWidth'], $thumb['maxHeight'], false, true);

			$data = [
				'uid'	=>	$uid,
				'info'	=>	$info,
				'img'	=>	$img,
				'sign'	=>	$sign,
				'addtime'	=>	time(),
				'status'	=>	1
			];
			if ($findOneByUid($uid)) {
				$result = $M_BestInvestor->where("uid=$uid and sign='$sign'")->save($data);
			} else {
				$result = $M_BestInvestor->add($data);
			}
			if ($result)
				$this->success('操作成功');
			$this->error('操作失败');

		} else if ($action == 'list') {
			$order = 'id desc';
			if (isset($_REQUEST['orderfield'])) {
				$orderfield = $_REQUEST['orderfield'];
				if (in_array($orderfield, ['id', 'vote'])) {
					$orderby = (isset($_REQUEST['order']) and in_array($_REQUEST['order'], ['asc', 'desc'])) 
						? $_REQUEST['order'] : 'desc';
					$order = $orderfield . ' ' . $orderby;
				}
			}
			$p = isset($_REQUEST['p']) ? intval($_REQUEST['p']) : 1;
			$pageSize = isset($_REQUEST['size']) ? intval($_REQUEST['size']) : 20;

			$list = $findList([
				'order' => $order,
				'p'	=>	$p,
				'pageSize'	=>	$pageSize
			]);
			$formatBestInvestor($list);
			$this->ajaxReturn($list);

		} else if ($action == 'vote') {
			if (empty($id))
				$this->error('参数错误');
			if (!$canVoteByUid($uid))
				$this->error('您已经参与投票');
			if ($vote = $voteExistByBidUid($id, $uid))
				$this->error('您已经投票该选项');
			$data = [
				'bid'	=>	$id,
				'uid'	=>	$uid,
				'status'=>	1,
				'sign'	=>	$sign,
				'addtime'	=>	time()
			];
			$M_BestInvestorVote->startTrans();
			if ($M_BestInvestorVote->add($data)) {
				if ($M_BestInvestor->where("id=$id")->setInc('vote')) {
					$M_BestInvestorVote->commit();
					$this->success('投票成功');
				}
				$M_BestInvestorVote->rollback();
			}
			$this->error('投票失败');

		} else if ($action == 'votes') {
			if (empty($id))
				$this->error('参数错误');
			$votes = $findVotes($id);
			$this->ajaxReturn($votes);

		} else if ($action == 'winner') {
			$list = $findVinner($winner_num);
			$this->ajaxReturn($list);

		} else if ($action == 'myvotes') {
			$list = $findUserVotes($uid);
			$this->ajaxReturn($list);
		}
	}
}

class Weixin
{

	const APPID		=	'wx2e1f086fa499385c';
	const SECRET	=	'42ca5714aa48eddf4546c4b96e02f4c9';
	const LANG		=	'zh_CN';
	
	private static $urls = [
		'base'	=>	'https://api.weixin.qq.com',
		'open_base'	=>	'https://open.weixin.qq.com',	

		'get_token'	=>	'/cgi-bin/token',
		'user_info'	=>	'/cgi-bin/user/info',
		'authorize'	=>	'/connect/oauth2/authorize',
		'sendmsg'	=>	'/cgi-bin/message/custom/send',

		'auth_token'	=>	'/sns/oauth2/access_token',//网页授权access_token,
		'userinfo'	=>	'/sns/userinfo'
	];

	public static function apiUrl($key, $open = false)
	{
		$urls = self::$urls;	
		$base = $open ? $urls['open_base'] : $urls['base'];
		return array_key_exists($key, $urls) ? $base . $urls[$key] : $base;
	}

	public static function post($urlKey, $data = [])
	{
		$res = Ops_Http::post(self::apiUrl($urlKey), $data, 10);
		$res = (array) json_decode($res);
		if (isset($res['errcode']))
			return $res['errmsg'];
		return $res;
	}

	public static function get($url)
	{
		$res = Ops_Http::get($url, 10);
		$res = (array) json_decode($res);
		if (isset($res['errcode']))
			return $res['errmsg'];
		return $res;
	}

	/**
	 * 获取基础接口access_token
	 */
	public static function accessToken()
	{
		static $access_token = null;
		if (!$access_token)
		{
			$data = [
				'appid'	=>	self::APPID,
				'secret'	=>	self::SECRET,
				'grant_type'	=>	'client_credential'
			];
			$access_token = self::post('get_token', $data)['access_token'];
		}
		return $access_token;
	}

	/**
	 * 网页授权
	 */
	public static function authorize($redirect_uri)
	{
		$location = self::apiUrl('authorize', true) . '?' 
			. 'appid=' . self::APPID
			. '&redirect_uri=' . urlencode($redirect_uri)
			. '&response_type=code&scope=snsapi_base#wechat_redirect';
		header("Location:$location");
	}

	/**
	 * 获取网页授权access_token
	 */
	public static function authAccessToken($code = '')
	{
		if ($code) {
			$data = [
				'appid'	=>	self::APPID,
				'secret'	=>	self::SECRET,
				'code'	=>	$code,
				'grant_type'	=>	'authorization_code'	
			];
			$res = self::post('auth_token', $data);
			if (is_string($res))
			{
				return [
					'error'	=>	true,
					'errmsg'	=>	$res
				];
			}
			self::setSession($res);
		}

		$weixin_oauth_token = self::getSession();
		if ($weixin_oauth_token['expires_time'] < time())
		{
			$res = self::refreshAuthAccessToken($weixin_oauth_token['refresh_token']);
			self::setSession($res);
			$weixin_oauth_token = self::getSession();
		}

		return $weixin_oauth_token['access_token'];
	}

	public static function setSession($token)
	{
		$expires_time = time() + $token['expires_in'] - 60;
		$token['expires_time'] = $expires_time;
		$_SESSION['weixin_oauth_token'] = $token;
	}

	public static function getSession($key = '')
	{
		$token = $_SESSION['weixin_oauth_token'];
		if (!is_array($token))
			return null;
		if (empty($key))
			return $token;
		return array_key_exists($key, $token) ? $token[$key] : null;	
	}

	public static function refreshAuthAccessToken($refresh_token)
	{
		$data = [
			'grant_type'	=>	'refresh_token',
			'refresh_token'	=>	$refresh_token
		];
		return self::post('refresh_token', $data);
	}

	/**
	 * 网页授权获取用户信息
	 */
	public static function userinfo()
	{
		$url = self::apiUrl('userinfo');
		$access_token = self::authAccessToken();
		$openid = self::getSession('openid');
		$lang = self::LANG;

		$url = "{$url}?access_token={$access_token}&openid={$openid}&lang={$lang}";
		return self::get($url);
	}

	/**
	 * openid来获取用户信息
	 */
	public static function user_info($openid)
	{
		$url = self::apiUrl('user_info');
		$access_token = self::accessToken();
		$lang = self::LANG;

		return self::get("{$url}?access_token={$access_token}&openid={$openid}&lang={$lang}");
	}

	public static function sendmsg($openid, $content, $msgtype = 'text')
	{
		$url = self::apiUrl('sendmsg');
		$access_token = self::accessToken();
		$url .= "?access_token={$access_token}";

		$data = '{
			"touser"	:	"'.$openid.'",
			"msgtype"	:	"'.$msgtype.'",
			"text"	:	{
				"content"	:	"'.$content.'"
			}	
		}';
		return self::dpost($url, $data);
	}

	/**
	 * post数据无需处理,直接提交
	 */
	public static function dpost($url, $data)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($curl);
		if (curl_errno($curl)) {
			return 'Errno'.curl_error($curl);
		}
		curl_close($curl);
		$res = (array) json_decode($res);
		if (isset($res['errcode']))
			return $res['errmsg'];
		return $res;
	}

}
