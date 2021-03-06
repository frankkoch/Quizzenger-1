<?php
	$viewInner->setTemplate ( 'user' );

	if (isset ( $this->request ['id'] )) {
		$userID = $this->request ['id'];
	} elseif ($GLOBALS['loggedin']) {
		$userID = $_SESSION ['user_id'];
	} else {
		header ( 'Location: ./index.php?view=login&pageBefore=' . $this->template );
		die ();
	}
	
	$user = $userModel->getUserByID ( $userID );
	$quizCount = $quizListModel->getUserQuizzesByUserIDCount ( $userID );
	$questionCount = $questionListModel->getQuestionsByUserIDCount ( $userID );
	$userscore = $userscoreModel->getUserScore($userID); 
	$categoryscores = $userscoreModel->getUserScoreAllCategories($userID);
	$moderatedCategories = $moderationModel->getModeratedCategoryNames($userID);
	$absolvedCount=$userModel->getQuestionAbsolvedCount($userID);
	
	if(isset($this->request['userReport']) && $GLOBALS ['loggedin']){
		$viewInner->assign ('message', mes_sent_report);
		if(isset($this->request['userreportDescription'])){
			$reportModel->addReport("user", $this->request ['id'], $this->request['userreportDescription'], $_SESSION['user_id'],NULL);
		} else {
			$reportModel->addReport("user", $this->request ['id'], NULL, $_SESSION['user_id'], NULL);
		}
	}
	$alreadyReported= $reportModel->checkIfUserAlreadyDoneReport("user", $userID, $_SESSION ['user_id']);
	
	
	$viewInner->assign ('alreadyreported',$alreadyReported);
	$viewInner->assign ( 'user', $user );
	$viewInner->assign ( 'quizcount', $quizCount );
	$viewInner->assign ( 'questioncount', $questionCount );
	$viewInner->assign ( 'userscore', $userscore );
	$viewInner->assign ( 'categoryscores', $categoryscores );
	$viewInner->assign ( 'moderatedcategories', $moderatedCategories );
	$viewInner->assign ( 'absolvedcount', $absolvedCount );
	
	
	
?>
