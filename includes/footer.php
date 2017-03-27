    </div> <!-- /container -->

    <footer>
    <div class="container footer">
        <div class="row" style="margin-top: 0px;">
            <div class="col-md-4">
                <?php
                    echo '<a href="index.php"><h4>' . $settings_title . '</h4></a>';
                    echo '<p>';
                    echo '&copy; ' . date("Y") . ' ' . $settings_title .'  - All rights reserved';
                    echo '</p>';
                    echo '<p>';
                    echo 'Icons from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a>';
                    echo '</p>';
                ?>
                
            </div>

            <div class="col-md-4">
                <h5>Newsletter</h5>

                <form class="form-inline">

                  <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email">
                  </div>
                  <button type="submit" class="btn btn-primary">Get Emails</button>
                </form>

            </div>

            <div class="col-md-4">
                <h5>Follow us</h5>
                <a href="#"><img class="followus" width="40px" src="images/facebook.png"></a>
                <a href="#"><img class="followus" width="40px" src="images/twitter.png"></a>
                <a href="#"><img class="followus" width="40px" src="images/instagram.png"></a>
            </div>
        </div>
    </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>