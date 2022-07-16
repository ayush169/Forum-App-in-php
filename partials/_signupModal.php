<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Create an Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/forum/partials/_handleSignup.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            spellcheck="false" placeholder="enter your name" onfocus="this.placeholder = ''"
                            onblur="this.placeholder = 'enter your name'">
                    </div>
                    <div class="form-group">
                        <label for="signupEmail">Username</label>
                        <input type="text" class="form-control" id="signupEmail" name="signupEmail"
                            aria-describedby="emailHelp" spellcheck="false" placeholder="enter your username">
                    </div>
                    <div class="form-group">
                        <label for="signupPassword">Password</label>
                        <input type="password" class="form-control" id="signupPassword" name="signupPassword"
                            onpaste="return false" onCopy="return false" onCut="return false"
                            placeholder="enter your password">
                    </div>
                    <div class="form-group">
                        <label for="signupcPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="signupcPassword" name="signupcPassword"
                            onpaste="return false" onCopy="return false" onCut="return false"
                            placeholder="re-enter your password">
                    </div>
                    <div class="modal-footer" style="justify-content:center;">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>