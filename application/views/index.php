<!DOCTYPE html>
<html lang="en">

<head>
	
    <meta charset="utf-8">
    
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
    <title>rivl</title>

    <link rel="shortcut icon" href="<?=base_url("/favicon.ico" )?>"/>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?=base_url("/css/bootstrap.css")?>"  media="screen"/>

    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>

    <link rel="stylesheet" href="<?=base_url("/css/main.css")?>"  media="screen"/>

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
                <li><a href="#competition_graph/<%=id%>">Graph</a></li>
                <li id="notifications" hidden><a href="#competitor_home/<%=id%>">Notifications <span class="badge">4</span></a></li>
                <li id="login" hidden><a>Login</a></li>
                <li id="logout" hidden><a>Logout</a></li>
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
            <td><%=date%></td>
            <td><strong><%=winner_name%></strong> vs <%=loser_name%></td>
            <td><strong><%=winner_score%></strong> - <%=loser_score%></td>
            <td><strong>+<%=winner_elo_change%></strong>&nbsp;&nbsp;<%=loser_elo_change%></td>
        </tr>
    </script>

	<script id="competitionGraphTemplate" type="text/template">
		<h1><%=name%> Graph</h1>
		<canvas id="mainGraph" width="1024" height="728"></canvas>
	</script>
		
	<script id="playerStatRowTemplate" type="text/template">
        <tr>
        <td><%=opponent_name%></td>
        <% var games = Number(win_num) + Number(loss_num); %>
        <td class="details"><%=games%></td>
        <td> (<strong>W:<%=win_num%></strong>  L:<%=loss_num%>)</td>
        <td><strong><%=avg_win_opp_score%></strong>, <%=avg_loss_score%></td>
        </tr>
    </script>

	<script id="playerPageTemplate" type="text/template">
		<h1><%=playerName%>'s stats</h1>
		<div id="competitors" class="sectionBody">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Games</th>
                        <th></th>
                        <th>Avg scores</th>
                    </tr>
                </thead>
                <tbody id="playerStats"></tbody>
            </table>
        </div>

		<h1>Graph</h1>
		<canvas id="playerGraph" width="1024" height="728"></canvas>
		<h1>Player History</h1>
        <div id="gameHistory" class="sectionBody">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Players</th>
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
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>Elo</th>
                        <th>Games</th>
                        <th></th>
                    </th>
                </thead>
                <tbody id="competitors"></tbody>
            </table>
        </div>
        <h1>Game History</h1>
        <div class="sectionBody">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Players</th>
                        <th>Score</th>
                        <th>Elo change</th>
                    </tr>
                </thead>
                <tbody id="gameHistory"></tbody>
            </table>
        </div>
    </script>
    
    <script id="competitorSelectionRowTemplate" type="text/template">
    	<option value="<%=competitor_id%>"><%=name%></option>
    </script>
    
    <script id="competitorRowTemplate" type="text/template">
        <% var elo = Math.round(elo); %>
        <td><%=document.getElementById('competitors').getElementsByTagName("tr").length + 1 %></td>
        <td><%=name%></td>
    	<td><%=elo%></td>
        <% var games = Number(wins) + Number(loses); %>
        <td class="details"><%=games%></td>
        <td> (W:<%=wins%>  L:<%=loses%>)</td>
    </script>

    <script id="gameRowTemplate" type="text/template">
        <tr>
            <td><%=game1.date%></td>
            <td><strong><%=game1.name%></strong> vs <%=game2.name%></td>
            <td><strong><%=game1.score%></strong> - <%=game2.score%></td>
            <td><strong>+<%=game1.elo_change%></strong>&nbsp;&nbsp;<%=game2.elo_change%></td>
        </tr>
    </script>


    
    <script id="newGameTemplate" type="text/template">
        <div style="margin-left: 50px;">
            
        <table style="width: 50%">
            <tr>
                <td><strong>Winner:</strong></td> <td><select id="winner"></select></td>
            </tr>
            <tr>
                <td><strong>Score:</strong></td>
                <td>
                    <strong id="winner_score">11</strong>
                </td>
            </tr>
            <tr>
                <td><strong>Loser:</strong></td> <td><select id="loser"></select></td>
            </tr>
            <tr>
                <td><strong>Score:</strong></td>
                <td>
                    <select id="loser_score">
                        <?php
                            for($i = 0; $i < 11; $i++) {
                        ?>
                                <option value='<?=$i?>'><?=$i?></option>
                        <?php       
                            }
                        ?>
                    </select>
                </td>
                <td></td>
            </tr>
        </table>

        <br />(in case of deuce put 10pts for the loser)<br />

        <span id="makeGame" class="button">Save game</span>
        </div>
    </script>
    
    <script id="newGame2Template" type="text/template">
            
        <div class="newGameContainer">
            <div id="playerSection" class="row text-left">
                <div class="col-xs-5">
                    <select id="player1">
                        <option value=''></option>
                    </select>
                </div>
                <div id="vsLabel" class="col-xs-2">
                </div>
                <div class="col-xs-5 text-right">
                    <select id="player2">
                        <option value=''></option>
                    </select>
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

    </script>

    <script id="newScoreTemplate" type="text/template">

        <div class="scoreRow span12">
            <div class="col-xs-6 text-center">
                <select class="scoreP1">
                    <option value=''></option>
                    <?php for($i = 11; $i >= 0; $i--) { ?>
                        <option value='<?=$i?>'><?=$i?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-xs-6 text-center">
                <select class="scoreP2">
                    <option value=''></option>
                    <?php for($i = 11; $i >= 0; $i--) { ?>
                        <option value='<?=$i?>'><?=$i?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </script>

    <script id="newResultsTemplate" type="text/template">

        <div class="resultsRow span12">
            <div class="col-xs-6 text-center">
                <span class="resultsP1 <% if (p1eloDelta > 0) { %>rankUp<% } else { %>rankDown<% } %>"><%= p1eloDelta %></span>
            </div>
            <div class="col-xs-6 text-center">
                <span class="resultsP2 <% if (p2eloDelta > 0) { %>rankUp<% } else { %>rankDown<% } %>"><%= p2eloDelta %></span>
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

    <script src=<?=base_url("/js/vs.js")?>></script>
    <script src=<?=base_url("/js/models/competition.js")?>></script>
    <script src=<?=base_url("/js/models/competitionCollection.js")?>></script>
    <script src=<?=base_url("/js/models/competitor.js")?>></script>
    <script src=<?=base_url("/js/models/competitionGraph.js")?>></script>
    <script src=<?=base_url("/js/models/competitorStat.js")?>></script>
    <script src=<?=base_url("/js/models/competitorCollection.js")?>></script>
    <script src=<?=base_url("/js/models/game.js")?>></script>
    <script src=<?=base_url("/js/models/gameSaver.js")?>></script>
    <script src=<?=base_url("/js/models/gameCollection.js")?>></script>

    <script src=<?=base_url("/js/views/competitionRow.js")?>></script>
    <script src=<?=base_url("/js/views/competitorRow.js")?>></script>
    <script src=<?=base_url("/js/views/competitorView.js")?>></script>
    <script src=<?=base_url("/js/views/competitionGraphView.js")?>></script>
    <script src=<?=base_url("/js/views/competitorStatView.js")?>></script>
    <script src=<?=base_url("/js/views/newGameView.js")?>></script>
    <script src=<?=base_url("/js/views/newGameView2.js")?>></script>
    <script src=<?=base_url("/js/views/gameHistoryView.js")?>></script>
    <script src=<?=base_url("/js/views/competitorSelectionRow.js")?>></script>
    <script src=<?=base_url("/js/views/gameRow.js")?>></script>
    <script src=<?=base_url("/js/views/allCompetitionsView.js")?>></script>
    <script src=<?=base_url("/js/views/competitionView.js")?>></script>
    <script src=<?=base_url("/js/router.js")?>></script>


</body>
</html>
