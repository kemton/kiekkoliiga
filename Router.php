<?php
/**
 * Kiekkoliiga Router
 * @author nikokiuru
 *
 */
class Router {

	private $pages = array();
	private $controllers = array();

	function __construct() {
		// Debug
		if (debug_mode == true)
			echo "<span style=\"color:red\">Method: " . __METHOD__ . ", Line: " . __LINE__ . "</span><br />\n";
		// All pages
		$this->pages = array(
		"homePage" => "home.php",
		"statisticsPage" => "statistics.php",
		"exceptionPage" => "exception.php",
		"teamPage" => "team.php",
		"standingsPage" => "standings.php",
		"scoreboardPage" => "scoreboard.php",
		"matchesPage" => "matches.php",
		"matchPage" => "match.php",
		"boardPage" => "board.php",
		"rulesPage" => "rules.php",
		"teamsPage" => "teams.php",
		"paitsioPage" => "paitsio.php",
		"archivesPage" => "archives.php",
		"feedbackPage" => "feedback.php",
		"hallOfFamePage" => "halloffame.php",
		"kiekkoCupPage" => "kiekkocup.php",
		"playerPage" => "player.php",
		"attackPage" => "attack.php",
		"defencePage" => "defence.php",
		"conferencePage" => "conference.php",
		"playoffsPage" => "playoffs.php",
		"reportPage" => "report.php",
		"error404Page" => "error404.php",
		"boardInfoPage" => "board-info.php",
		"reportPage" => "report.php",
		"pagePage" => "page.php",
		"rulesPage" => "rules.php",
		"leagueStatsPage" => "leaguestats.php",
		"achievementsPage" => "achievements.php",
		"unityPage" => "unity.php",
		"kiekkotkStatsPage" => "kiekkotk_stats.php",
		"uploadPage" => "upload.php",
		"uploadMatchPage" => "upload_match.php"
		);

		// All controllers
		$this->actions = array(
		"archives" => ArchivesController,
		"board" => BoardController,
		"board-info" => BoardInfoController,
		"deadline" => DeadlineController,
		"feedback" => FeedbackController,
		"home" => HomePageController,
		"http-error" => HttpErrorController,
		"kiekko-cup" => KiekkoCupController,
		"login" => LogInController,
		"paitsio" => PaitsioController,
		"player" => PlayerController,
		"report" => ReportController,
		"statistics" => StatisticsController,
		"team" => TeamPageController,
		"teams" => TeamsController,
		"PageController" => PageController,
		"rules" => PageController,
		"hall-of-fame" => PageController,
		"unity" => UnityController,
		"upload" => UploadController
		);
	}

	public function doRequest($controller, $context) {
		// default page
		$target = "home";
		$action = $controller[0];
		
		// Save new season to session
		if (is_numeric($_REQUEST["season"])) {
			$id = $_REQUEST["season"];
			$seasonController = new SeasonController();
			$season = $seasonController->getSeasonById($id);
			$_SESSION["season"] = $season;
		}
		// Set season if is not set before
		if (!isset($_SESSION["season"])) {
			$seasonController = new SeasonController();
			$season = $seasonController->getCurrentSeason();
			$_SESSION["season"] = $season;
		}
		
		$this->nextController(null, 'deadline');
		
		if ($action == 'ajax'){ include(viewDir . $action . "/" . $controller[1]); return null; }
		// if smf logged in
		if ($context["user"]["is_logged"] == 1) { $this->nextController($context, 'login'); }
		//  && !isset($_SESSION["user"])
		
		/*if ($this->actions[$action] == null && $action <> '') {
			$action = "PageController";
			$target = $this->nextController($controller, $action);
		}*/
		if ($action == null) {
			$target = $this->nextController($controller, $target);
		} else {
			$target = $this->nextController($controller, $action);
		}
		
		$_REQUEST["page"] = $target;
		
		
		// import target page
		/* PageController fix test
		$isFolder = explode('/', $target);
		$folderAppend = "";
		if($controller[0] && $target != "exception.php") {
			if (count($isFolder) >= 2) {
				$folderAppend = explode('/', $isFolder) . "/";
			} else {
				$folderAppend = $controller[0] . "/";
			}
		}*/
		
		$folderAppend = "";
		if($controller[0] && $target != "exception.php") {
			$folderAppend = $controller[0] . "/";
		}
		
		// ForumController return FALSE (symlink)
		if ($target == NULL || $target == FALSE) {
			$viewPath = NULL;
		} else {
			$viewPath = viewDir . $folderAppend . $target;
		}
		
		return $viewPath;
	}

	private function nextController($controller, $action) {
	
		// Loopping actions while action is null
		while ($this->actions[$action] != null) {
			$actionValue = $this->actions[$action];
			$action = $this->controllerHandler($controller, $actionValue);
		}
		
		// Seek right page
		if ($this -> pages[$action] <> null) {
			$target = $this->pages[$action];
		} else if ($target <> FALSE) {
			$target = $this->pages["exceptionPage"];
		}
		return $target;
	}

	private function controllerHandler($controller, $actionValue) {
		try {
			// call correct class
			$actor = new $actionValue;
			$target = $actor->execute($controller);
		} catch (Exception $e) {
			$_REQUEST["exception"] = $e->getMessage() . "<br />";
			$target = "exceptionPage";
		}
		return $target;
	}

}
?>