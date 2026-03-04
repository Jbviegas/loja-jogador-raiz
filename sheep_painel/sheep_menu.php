<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="sheep.php" title="Sheep Framework PHP - Por: MAYKONSILVEIRA.COM.BR ">
        <img alt="<?= SITENAME ?>" src="<?= HOME ?>/img-logo/images/2024/13/nova-logo-transparente.png" class="header-logo" style="margin-top:5px; width:70%; height: auto;" /> <span class="logo-name"></span>
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Sheep PHP</li>
      <li class="dropdown active">
        <a href="sheep.php" class="nav-link"><i data-feather="monitor"></i><span>Painel</span></a>
      </li>

      <li class="menu-header">Personalizações</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="cpu"></i><span>Configurações</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?= FILTROS ?>sheep-dados/index&token=<?= $_SESSION['timeWT'] ?>">Configurações</a></li>
          <li><a class="nav-link" href="<?= FILTROS ?>sheep-efi/index&token=<?= $_SESSION['timeWT'] ?>">Banco Efí</a></li>
        </ul>
      </li>

      <li class="menu-header">Departamentos</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="list"></i><span>Categorias</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-categorias/index&token=<?= $_SESSION['timeWT'] ?>">Departamentos</a></li>

        </ul>
      </li>

      <li class="menu-header">Produtos</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f" style="margin-right: 7px;">
            <path d="M841-518v318q0 33-23.5 56.5T761-120H201q-33 0-56.5-23.5T121-200v-318q-23-21-35.5-54t-.5-72l42-136q8-26 28.5-43t47.5-17h556q27 0 47 16.5t29 43.5l42 136q12 39-.5 71T841-518Zm-272-42q27 0 41-18.5t11-41.5l-22-140h-78v148q0 21 14 36.5t34 15.5Zm-180 0q23 0 37.5-15.5T441-612v-148h-78l-22 140q-4 24 10.5 42t37.5 18Zm-178 0q18 0 31.5-13t16.5-33l22-154h-78l-40 134q-6 20 6.5 43t41.5 23Zm540 0q29 0 42-23t6-43l-42-134h-76l22 154q3 20 16.5 33t31.5 13ZM201-200h560v-282q-5 2-6.5 2H751q-27 0-47.5-9T663-518q-18 18-41 28t-49 10q-27 0-50.5-10T481-518q-17 18-39.5 28T393-480q-29 0-52.5-10T299-518q-21 21-41.5 29.5T211-480h-4.5q-2.5 0-5.5-2v282Zm560 0H201h560Z" />
          </svg>
          <span>Loja</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-produtos/index&token=<?= $_SESSION['timeWT'] ?>">Produtos</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/aprovados_mes&token=<?= $_SESSION['timeWT'] ?>">Compras</a></li>
          <li><a href="<?= FILTROS ?>sheep-produtos/estoque&token=<?= $_SESSION['timeWT'] ?>">Estoque</a></li>
        </ul>
      </li>

      <li class="menu-header">Compras</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-cart"></i><span>Compras da Loja</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-compras/index&token=<?= $_SESSION['timeWT'] ?>">Todas as Compras</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/aprovados_dia&token=<?= $_SESSION['timeWT'] ?>">Compras do Dia</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-compras/aprovados_mes&token=<?= $_SESSION['timeWT'] ?>">Compras Aprovadas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/aprovados&token=<?= $_SESSION['timeWT'] ?>">Compras Aprovadas Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-compras/pendente_mes&token=<?= $_SESSION['timeWT'] ?>">Compras Pendentes Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/pendente&token=<?= $_SESSION['timeWT'] ?>">Compras Pendentes Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-compras/finalizados_mes&token=<?= $_SESSION['timeWT'] ?>">Compras Finalizadas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/finalizados&token=<?= $_SESSION['timeWT'] ?>">Compras Finalizadas Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-compras/cancelados_mes&token=<?= $_SESSION['timeWT'] ?>">Compras Canceladas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-compras/cancelados&token=<?= $_SESSION['timeWT'] ?>">Compras Canceladas Ano</a></li>
        </ul>
      </li>


      <li class="menu-header">Banners</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="award"></i><span>Publicidades</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-destaque/index&token=<?= $_SESSION['timeWT'] ?>">Destaques</a></li>
          <li><a href="<?= FILTROS ?>sheep-banners/index&token=<?= $_SESSION['timeWT'] ?>">Banners e Logos</a></li>
        </ul>
      </li>

      <li class="menu-header">Relatórios</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="pie-chart"></i><span>Relatórios da Loja</span></a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-relatorios/index&token=<?= $_SESSION['timeWT'] ?>">Visitas em Produtos</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturamento_mes&token=<?= $_SESSION['timeWT'] ?>">Faturamento Mensal</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturamento_anual&token=<?= $_SESSION['timeWT'] ?>">Faturamento Anual</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_aprovadas_mes&token=<?= $_SESSION['timeWT'] ?>">Faturas Aprovadas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_aprovadas&token=<?= $_SESSION['timeWT'] ?>">Faturas Aprovadas Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_pendentes_mes&token=<?= $_SESSION['timeWT'] ?>">Faturas Pendentes Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_pendentes&token=<?= $_SESSION['timeWT'] ?>">Faturas Pendentes Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_finalizadas_mes&token=<?= $_SESSION['timeWT'] ?>">Faturas Finalizadas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_finalizadas&token=<?= $_SESSION['timeWT'] ?>">Faturas Finalizadas Ano</a></li>
          <br>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_canceladas_mes&token=<?= $_SESSION['timeWT'] ?>">Faturas Canceladas Mês</a></li>
          <li><a href="<?= FILTROS ?>sheep-relatorios/faturas_canceladas&token=<?= $_SESSION['timeWT'] ?>">Faturas Canceladas Ano</a></li>
        </ul>

      <li class="menu-header">Clientes e Usuários</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f" style="margin-right: 7px;">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>Usuarios </span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?= FILTROS ?>sheep-usuarios/index&token=<?= $_SESSION['timeWT'] ?>">Listar</a></li>
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