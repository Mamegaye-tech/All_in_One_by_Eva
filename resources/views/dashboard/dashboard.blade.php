<form action="{{ route('logout') }}" method="POST">
 @csrf
<button type="submit">
<i class="fas fa-sign-out-alt"></i>Déconnexion </button>

</form>