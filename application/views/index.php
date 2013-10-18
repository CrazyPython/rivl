<!DOCTYPE html>
<html lang="en">

<head>

    <?php $randomlol = rand(0,100000); ?>

    <meta charset="utf-8">
    
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0, user-scalable = 0" />
    <title>rivl</title>

    <link rel="shortcut icon" href="<?=base_url("/favicon.ico" )?>"/>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?=base_url("/css/bootstrap.css")?>"  media="screen"/>

    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>

    <link rel="stylesheet" href="<?=base_url("/css/main.css?moo=")?><?=$randomlol?>"  media="screen"/>

</head>

<body>

    <div id="mainContainer" class="container">

    </div>


    <!-- Templates -->

    <script id="navbarTemplate" type="text/template">
        <div class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">rivl</a>
            </div>
            <div class="collapse navbar-collapse">
              <% if (id !== 0) { %>
              <ul class="nav navbar-nav">
                <li><a href="#competition/<%=id%>">Home</a></li>
                <li><a href="#competition/<%=id%>/game">Enter scores</a></li>
                <li><a href="#">Compare rivls</a></li>
                <li><a href="#competition_graph/<%=id%>">Graph</a></li>
                <li id="notifications" class="hide"><a href="#competitor_home/<%=id%>">Notifications <span class="badge">4</span></a></li>
                <li id="login" class="hide"><a>Login</a></li>
                <li id="logout" class="hide"><a>Logout</a></li>
              </ul>
              <% } %>
            </div><!--/.nav-collapse -->
          </div>
        </div>

    </script>

    <script id="notifications" type="text/template">
        Notifications go here
    </script>

    <script id="competitionRowTemplate" type="text/template">
        <a><%=name%></a>
    </script>

	<script id="competitorGameRowTemplate" type="text/template">
        <tr>
            <!--<td><%=date%></td>-->
            <td><% if (playerScore === '11') { %><strong><% } %><%=vsPlayer%></td><% if (playerScore === '11') { %></strong><% } %></td>
            <td><% if (playerScore === '11') { %><strong><% } %><%=playerScore%>&nbsp;-&nbsp;<%=vsScore%><% if (playerScore === '11') { %></strong><% } %></td>
            <td><% if (playerScore === '11') { %><strong>+<% } %><%= Math.round(playerElo*10) / 10 %></td><% if (playerScore === '11') { %></strong><% } %></td>
        </tr>
    </script>

	<script id="competitionGraphTemplate" type="text/template">
		<h1><%=name%> Graph</h1>
		<canvas id="mainGraph" width="1024" height="728"></canvas>
	</script>
		
	<script id="playerStatRowTemplate" type="text/template">
        <% var games = Number(win_num) + Number(loss_num); %>
        <% var winPercent = Math.round(Number(win_num) / Number(games) * 100); %>
        <div class="row">
            <div class="col-xs-4">
                <%=opponent_name%>
            </div>
            <div class="col-xs-4">
                Won <strong><%=win_num%></strong>/<%=games%> (<%=winPercent%>%)
            </div>
            <div class="col-xs-4">
                <button class="btn btn-block btn-sm btn-default" onclick="console.log('compareRivls(Liam, Dean)');">Compare rivls</button>
            </div>
        </div>
    </script>

	<script id="playerPageTemplate" type="text/template">
		<h1><%=playerName%></h1>
		<div class="sectionBody">
            <!--
            <div class="row">
                <div class="col-xs-4">
                    <h3 class="bigVal">1687</h3>
                    <p>elo score</p>
                </div>
                <div class="col-xs-4">
                    <h3 class="bigVal"><span id="playerGamesWon">67</span><small>/<span id="playerGamesPlayed">100</span></small></h3>
                    <p>games won (<span id="playerWinPercent">67</span>%)</p>
                </div>

                <div class="col-xs-4">
                    <h3 class="bigVal"><span id="playerRank">5th</span></h3>
                    <p>of <span id="playersTotal">18</span> players</p>
                </div>

            </div>
            -->
            
            <h2>Top rivls</h2>
            <div id="playerStats">
            </div>
            <a href="#" id="topRivlsShowMore">Show more</a>

        </div>

        <!--<h2>Current titles</h2>
        <div class="row">
            <div class="col-xs-12">
                <h4 class="bigVal"><span class="glyphicon glyphicon-fire"></span> The bully</h4>
                <p>Hey, pick on someone your own size!</p>
            </div>
            <div class="col-xs-12">
                <h4 class="bigVal"><span class="glyphicon glyphicon-cutlery"></span> Game hungry</h4>
                <p>You can&apos;t keep <%=playerName%> away from the action</p>
            </div>
        </div>-->

		<h2>Elo over time</h2>
		<canvas id="playerGraph" width="1024" height="728"></canvas>
		
        <h2>Recent games</h2>
        <div id="gameHistory" class="sectionBody">
            <table class="dataTable">
                <thead>
                    <tr>
                        <!--<th>Date</th>-->
                        <th>Opponent</th>
                        <th>Score</th>
                        <th>Elo change</th>
                    </tr>
                </thead>
                <tbody id="playerHistory"></tbody>
            </table>
        </div>
	</script>

    <script id="competitionTemplate" type="text/template">

        <h1><%=name%> Leaderboard</h1>
        <div class="sectionBody">
            <table class="dataTable rowLinks">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Elo</th>
                        <th></th>
                    </th>
                </thead>
                <tbody id="competitors"></tbody>
            </table>
        </div>
        <h2>Game History</h2>
        <div class="sectionBody">
            <table class="dataTable">
                <thead>
                    <tr>
                        <!--<th>Date</th>-->
                        <th>Players</th>
                        <th>Score</th>
                        <th>Elo change</th>
                    </tr>
                </thead>
                <tbody id="gameHistory"></tbody>
            </table>
        </div>
    </script>
    
    <script id="competitorRowTemplate" type="text/template">
        <% var elo = Math.round(elo); %>
        <td><%=document.getElementById('competitors').getElementsByTagName("tr").length + 1 %></td>
        <td><%=name%></td>
    	<td><%=elo%></td>
        
    </script>

    <script id="gameRowTemplate" type="text/template">
        <% var game1_elo_change = Math.round(game1.elo_change * 10 ) / 10; %>
        <% var game2_elo_change = Math.round(game2.elo_change * 10 ) / 10; %>
        <tr>
            <td><strong><%=game1.name%></strong> vs <%=game2.name%></td>
            <td><strong><%=game1.score%></strong> - <%=game2.score%></td>
            <td><strong>+<%=game1_elo_change%></strong>&nbsp;&nbsp;<%=game2_elo_change%></td>
        </tr>
    </script>

    <script id="newGame2Template" type="text/template">
            
        <div class="newGameContainer sectionBody">
            <div id="playerSection" class="row text-center">
                <div id="selectPlayer1" class="col-xs-5">
                    <img src="img/avatars/anonymous.png" />
                    <br />
                    <span></span>
                </div>
                <div id="vsLabel" class="col-xs-2">
                </div>
                <div id="selectPlayer2" class="col-xs-5 text-center">
                    <img src="img/avatars/anonymous.png" />
                    <br />
                    <span></span>
                </div>
            </div>
            <div id="scoresSection" class="row"></div>
            <div id="resultsSection" class="row"></div>
            
            <div id="buttonsSection" class="row">
                <div class="col-xs-12 text-center">
                    <button id="addScore" class="btn btn-sm btn-default">Add another score</button>
                    <button id="removeScore" class="btn btn-sm btn-danger">Remove last score</button>
                    <button id="submitScore" class="btn btn-lg btn-success btn-block">Save scores</button>                
                </div>
            </div>
        </div>


            <div id="playerSelectModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Select players</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group"></ul>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
    </script>

    <script id="newPlayerSelectRowTemplate" type="text/template">
        <li class="list-group-item playerSelection" data-competitor_id="<%=competitor_id%>">
            <%=name%>
        </li>
    </script>

    <script id="newScoreTemplate" type="text/template">

        <div class="scoreRow span12">
            <div class="col-xs-6 text-center">
                <select class="scoreP1">
                    <option value=''></option>
                    <% for (var i = points; i > 0; i--) { %>
                        <option value='<%= i %>'><%= i %></option>
                    <% } %>
                </select>
            </div>
            <div class="col-xs-6 text-center">
                <select class="scoreP2">
                    <option value=''></option>
                    <% for (var i = points; i > 0; i--) { %>
                        <option value='<%= i %>'><%= i %></option>
                    <% } %>
                </select>
            </div>
        </div>
    </script>

    <script id="newResultsTemplate" type="text/template">


        <div class="resultsRow span12">
            <div class="col-xs-5 text-center">
                <% if (p1eloDelta > 0) { %>
                    <span class="resultsP1 rankUp"><%= p1eloDelta %></span>
                <% } else if (p1eloDelta < 0) { %>
                    <span class="resultsP1 rankDown"><%= p1eloDelta %></span>
                <% } %>
            </div>
            <div class="col-xs-2"></div>
            <div class="col-xs-5 text-center">
                <% if (p2eloDelta > 0) { %>
                    <span class="resultsP2 rankUp"><%= p2eloDelta %></span>
                <% } else if (p2eloDelta < 0) { %>
                    <span class="resultsP2 rankDown"><%= p2eloDelta %></span>
                <% } %>
            </div>
        </div>
        <div class="resultsRow span12">
            <div class="col-xs-5 text-center">
                <span class="resultsP1">
                    <% if (p1rankDelta > 0) { %>Rank up: +<%= p1rankDelta %><% } else if (p1rankDelta < 0) { %>Rank down: <%= p1rankDelta %><% } %>
                </span>
            </div>
            <div class="col-xs-2"></div>
            <div class="col-xs-5 text-center">
                <span class="resultsP2">
                    <% if (p2rankDelta > 0) { %>Rank up: +<%= p2rankDelta %><% } else if (p2rankDelta < 0) { %>Rank down: <%= p2rankDelta %><% } %>
                </span>
            </div>
        </div>
    </script>
            
            
    <script src="https://login.persona.org/include.js"></script>
    <script src=<?=base_url("/js/lib/json2.js")?>></script>
    <script src=<?=base_url("/js/lib/jquery-1.7.1.js")?>></script>
    <script src=<?=base_url("/js/lib/underscore.js")?>></script>
    <script src=<?=base_url("/js/lib/backbone.js")?>></script>
    <script src=<?=base_url("/js/lib/bootstrap.js")?>></script>
	<script src=<?=base_url("/js/lib/Chart.js")?>></script>
    <script src=<?=base_url("/js/lib/fastclick.js")?>></script>

	<script type="text/javascript">
	    navigator.id.watch({
	        loggedInUser: <?= $email ? "'$email'" : 'null' ?>,
	        // A user has logged in! Here you need to:
		    // 1. Send the assertion to your backend for verification and to create a session.
		    // 2. Update your UI.
			onlogin: function(assertion) {
				
			    $.ajax({ /* <-- This example uses jQuery, but you can use whatever you'd like */
				      type: 'POST',
				      url: "<?=base_url('/auth/login')?>", // This is a URL on your website.
				      data: {assertion: assertion},
				      success: function(res, status, xhr) { 
				      	$('#login').hide();
				      	$('#logout').show();
				      	$('#notifications').show();
				      },
				      error: function(xhr, status, err) {
				        navigator.id.logout();
				        $('#login').show();
				      	$('#logout').hide();
				      	$('#notifications').hide();
				      }
			    });
		  	},
		  onlogout: function() {
			    // A user has logged out! Here you need to:
			    // Tear down the user's session by redirecting the user or making a call to your backend.
			    // Also, make sure loggedInUser will get set to null on the next page load.
			    // (That's a literal JavaScript null. Not false, 0, or undefined. null.)
			    $.ajax({
			      type: 'POST',
			      url: "<?=base_url('/auth/logout')?>", // This is a URL on your website.
			      success: function(res, status, xhr) { 
			      	$('#login').show();
			      	$('#logout').hide();
			      	$('#notifications').hide(); 
		      	},
			      error: function(xhr, status, err) { alert("Logout failure: " + err); }
			    });
		   }
	    });
    </script>

	<script type="text/javascript">
			$(function() {
	    		$('#mainContainer').on('click','#login',function(){
	    			navigator.id.request();
	    		});
	    		$('#mainContainer').on('click','#logout',function(){
	    			navigator.id.logout();
	    		});
			});
	</script>

    <script src=<?=base_url("/js/vs.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competition.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competitionCollection.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competitor.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competitionGraph.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competitorStat.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/competitorCollection.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/game.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/gameSaver.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/models/gameCollection.js?moo=")?><?=$randomlol?>></script>

    <script src=<?=base_url("/js/views/competitionRow.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/competitorRow.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/competitorView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/competitionGraphView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/competitorStatView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/newGameView2.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/gameHistoryView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/gameRow.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/allCompetitionsView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/views/competitionView.js?moo=")?><?=$randomlol?>></script>
    <script src=<?=base_url("/js/router.js?moo=")?><?=$randomlol?>></script>


</body>
</html>
