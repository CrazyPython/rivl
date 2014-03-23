<script id="newGame2Template" type="text/template">
		<h1><%=name%></h1>
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
                    <button id="addScore" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-plus"></span> Add another result</button>
                    <button id="removeScore" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-minus"></span> Remove last result</button>
                    <br><br><button id="addNote" class="btn btn-sm btn-default">Add game note</button>
                    <button id="removeNote" class="btn btn-sm btn-default">Remove game note</button>
                    <button id="submitScore" class="btn btn-lg btn-success btn-block">Save result</button>
                </div>
            </div>
        </div>

            <div id="playerSelectModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content row">
                        <div class="modal-header col-xs-6 columns">
                            <h4 class="modal-title">Player 1</h4>
                        </div>
                        <div class="modal-header col-xs-6 columns">
                            <h4 class="modal-title">Player 2</h4>
                        </div>
                        <div class="modal-body">
                            <ul id="left_player_select" class="list-group col-xs-6"></ul>
                            <ul id="right_player_select" class="list-group col-xs-6"></ul>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
    </script>