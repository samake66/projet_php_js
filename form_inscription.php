<form action="inscription.php" method="POST">
  <div class="mb-3">
    <label for="exampleInputName" class="form-label">Nom</label>
    <input type="text" class="form-control" id="exampleInputName" name="name">
  </div>
  
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Adresse e-mail</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre adresse e-mail avec personne.</div>
  </div>
  
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
  </div>

  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
