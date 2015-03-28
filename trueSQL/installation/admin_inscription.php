                    <form class="form-horizontal" method="POST" action="<?php filter_input(INPUT_SERVER, "PHP_SELF") ?>">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="pseudo">Pseudo:</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="text"  name="pseudo" placeholder="Pseudo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="password">Mot de Passe:</label>
                            <div class="col-sm-6">
                                <input class="form-control" type="password" name="password" placeholder="Mot de passe">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <input class="btn btn-default" type="submit" value="enregistrer">
                            </div>
                        </div>
                    </form>