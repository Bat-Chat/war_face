<div class="content">
      <div class="title">Авторизация</div> 
      <div class="form">
        <div class="f-title">Заполните поле и нажмите кнопку "Получить контент"</div>
       <form action="" method="post" name="form" id="form">
        <input type="hidden" name="enter" value="1" />
          <div class="f-item f-first">
            <label>Телефон</label>
            <input type="text" name="number" value="+7" onkeypress="if (event.keyCode==13) {$('#form').submit(); return false;};" />
            <div class="message">Например: +79991115566</div>
          </div>
        </form>
      </div>
      <a href="#" class="playw continue" onclick="$('#form').submit(); return false;">Получить Контент</a>
        <div class="error"><?php echo $error ?></div>
      <div class="top-players">
        <div class="top-title"></div>
          <ul class="list">
            <li>
              <div class="name"><?php echo $_SESSION['throne_players_top']['nicks'][0] ?></div>
              <div class="phone">(<?php echo $_SESSION['throne_players_top']['numbers'][0] ?>)</div>
              <div class="score"><?php echo $_SESSION['throne_players_top']['stars'][0] ?></div>
              <div class="armor"><?php echo $_SESSION['throne_players_top']['battles'][0] ?></div>
              <div class="hours"><?php echo $_SESSION['throne_players_top']['hours'][0] ?> ч</div>
            </li>
            <li>
              <div class="name"><?php echo $_SESSION['throne_players_top']['nicks'][1] ?></div>
              <div class="phone">(<?php echo $_SESSION['throne_players_top']['numbers'][1] ?>)</div>
              <div class="score"><?php echo $_SESSION['throne_players_top']['stars'][1] ?></div>
              <div class="armor"><?php echo $_SESSION['throne_players_top']['battles'][1] ?></div>
              <div class="hours"><?php echo $_SESSION['throne_players_top']['hours'][1] ?> ч</div>
            </li>
            <li>
              <div class="name"><?php echo $_SESSION['throne_players_top']['nicks'][2] ?></div>
              <div class="phone">(<?php echo $_SESSION['throne_players_top']['numbers'][2] ?>)</div>
              <div class="score"><?php echo $_SESSION['throne_players_top']['stars'][2] ?></div>
              <div class="armor"><?php echo $_SESSION['throne_players_top']['battles'][2] ?></div>
              <div class="hours"><?php echo $_SESSION['throne_players_top']['hours'][2] ?> ч</div>
            </li>
            <li>
              <div class="name"><?php echo $_SESSION['throne_players_top']['nicks'][3] ?></div>
              <div class="phone">(<?php echo $_SESSION['throne_players_top']['numbers'][3] ?>)</div>
              <div class="score"><?php echo $_SESSION['throne_players_top']['stars'][3] ?></div>
              <div class="armor"><?php echo $_SESSION['throne_players_top']['battles'][3] ?></div>
              <div class="hours"><?php echo $_SESSION['throne_players_top']['hours'][3] ?> ч</div>
            </li>
            <li>
              <div class="name"><?php echo $_SESSION['throne_players_top']['nicks'][4] ?></div>
              <div class="phone">(<?php echo $_SESSION['throne_players_top']['numbers'][4] ?>)</div>
              <div class="score"><?php echo $_SESSION['throne_players_top']['stars'][4] ?></div>
              <div class="armor"><?php echo $_SESSION['throne_players_top']['battles'][4] ?></div>
              <div class="hours"><?php echo $_SESSION['throne_players_top']['hours'][4] ?> ч</div>
            </li>
          </ul>
      </div>   
</div>