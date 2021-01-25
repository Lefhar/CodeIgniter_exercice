<!-- application/views/validationemail.php -->
<div class="container">
    <div class="row">
        <div class="col-12">

            <article>
                <div class="card m-4  p-5"  >
                    <div class="card-body">
                    <h5 class="card-title">validation d'adresse email</h5>
                        <p class="card-text"> <?php

                   if(!empty($error)){ echo$error;}
                            ?>  </p>

                        </div>
                    </div>

        </article>

        </div>
    </div>
</div>