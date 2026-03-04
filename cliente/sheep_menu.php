<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="sheep.php" title="<?= SITENAME ?>"> <img alt="<?= SITENAME ?>"
          src="<?= HOME ?>/uploads/img-logo/images/2024/13/nova-logo-transparente.png" class="header-logo" style="margin-top:5px; width:70%; height: auto;" />
        <span class="logo-name"></span>
      </a>
    </div>
    <ul class="sidebar-menu">

      <li class="menu-header">Voltar aonde estava</li>

      <li onclick="history.back()" style="margin-left: 15px; cursor:pointer; display:flex; align-items:center; font-weight:bold; color:black">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
          <path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z" />
        </svg><span> Voltar</span>
      </li>

      <li class="menu-header">Painel do Cliente</li>
      <li class="dropdown active">
        <a href="sheep.php" class="nav-link text-dark"><i data-feather="monitor"></i><span>Painel</span></a>
      </li>


      <li class="menu-header">Compras</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-cart"></i><span>Minhas Compras</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?>">Compras Pendentes</a></li>
          <li><a href="<?= FILTROS ?>sheep-produtos/aprovados&token=<?= $_SESSION['timeWT'] ?>">Compras Aprovadas</a></li>
          <li><a href="<?= FILTROS ?>sheep-produtos/finalizados&token=<?= $_SESSION['timeWT'] ?>">Compras Finalizadas</a></li>
          <li><a href="<?= FILTROS ?>sheep-produtos/cancelados&token=<?= $_SESSION['timeWT'] ?>">Compras Canceladas</a></li>
        </ul>
      </li>



      <li class="menu-header">Meus Dados</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f" style="margin-right: 7px;">
            <path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z" />
          </svg>
          <span>Configurações</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>">Minha Conta</a></li>


        </ul>
      </li>

      <li class="menu-header">Sair</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f" style="margin-right: 7px;">
            <path d="M760-200v-160q0-50-35-85t-85-35H273l144 144-57 56-240-240 240-240 57 56-144 144h367q83 0 141.5 58.5T840-360v160h-80Z" />
          </svg>
          <span>Sair do Painel</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= HOME ?>">Voltar ai início da loja</a></li>
          <li><a href="sheep.php?sair=true">Sair da Conta</a></li>
        </ul>
      </li>
      <br>
      <br>
      <br>
      <br>
      <br>
    </ul>
  </aside>
</div>