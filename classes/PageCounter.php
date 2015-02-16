<?php
	
	/*
	Script by programmer of "Irbis Team" Gagolkin Denis
	
	При создании класса ему нужно передать следующие данные:
	1) Название таблицы
	2) Условие WHERE
	3) Количество выводимых записей на страницу
	4) Текущую страницу
	
	Метод start_page() вызывается для получения первого параметра в LIMIT-е запроса вывода данных из базы. LIMIT X,Y, где X - это $counter->start_page(), а Y - это $quantity
	
	Интеграция следующая:
	1) Подключаем класс:
	   include  SETUP_DIR .'classes/PageCounter.php';	
	2) Определяем название таблицы:
	   $table='photo';
	3) Определяем условие выборки из базы:
	   $where = 'WHERE `user`= ' . $user_data['id_user'];
	4) Определяем, сколько нам нужно записей на странице
	   $quantity = 8; 
	5) Создаем экземпляр класса (текущая страница хранится в $_GET['page']:
	   $counter = new counter('message', $where, $quantity, $_GET['page']);
	6) Для вывода самого меню вызываем метод:
       echo $counter->list_menu(5);
	   5-это интервал вывода страниц, т.е. в данном случае меню будет выглядеть например так: 1 2 3 4 5 ... 18
	7) В выводе данных добавляем лимит
	   LIMIT ".$counter->start_page().", " .$quantity
	*/
	

  class page_counter
  {
    public $total;  //всего страниц
	public $page;  //текущая страница
	public $all_quantity;  //всего записей в таблице, удовлетворяющих условию
	public $quantity; //записей на страницу
	
    #Метод определения количества записей в таблице
    function __construct($table, $where, $quantity, $page)
    {  
      $this->quantity = $quantity; 
  	  $this->page = intval($page);
	  
      $result = $this->query("SELECT COUNT(*)
                              FROM `".$table."` ".$where
		    				  , __FILE__, __LINE__);
	  
      $this->all_quantity = mysql_result($result, 0); 
	  
	  #Всего страниц
      $this->total = ceil($this->all_quantity / $this->quantity);	
	  
	  if($this->page > $this->total)  
        $this->page = $this->total;  
	  elseif($this->page < 0 || empty($this->page))
	    $this->page = 1;
    }	

    #Обертка для MySQL запросов  
    private function query($sql, $file, $line)
    {
      $res = mysqlQuery($sql, CONNECT);
       
      if($res)
      {
        return $res;
      }
      else
      {
       die('<b style="color:red">Mysql error: </b>' . mysql_error() . '<br><b>Query: </b>' . $sql . '<br><b>File:
        </b>' . $file . '<br><b>Line: </b>' . $line);	 
 /*        header('location: error.html');*/ 
        exit;
      }
    }	

    #Определение стартовой страницы
    public function start_page()
    {
      $start = $this->page * $this->quantity - $this->quantity; 	
      return $start; 
    }
  }
  

  
  #Меню 
  class counter extends page_counter
  {  
    function list_menu($interval) 
    {
	  $menu = '';  
	  
	  $get =  preg_replace('#&num=\d+#', '', $_SERVER['QUERY_STRING']);
	  
	  //Находимся на страницах с 1 по 5. Количество страниц больше 4
	  if ($this->page < $interval && $this->total > ($interval - 1))
	  {
		for ($i = 1; $i < ($interval + 1); $i++) 
		{
          if($this->page == $i) 
            $menu .= '<li class="active"><a href="#">'.$i.'</a></li>';
          else  
            $menu .= '<li><a href="?' . $get . '&num='.$i.'" />'.$i.'</a></li>'; 
		}
   		  if($this->total > $interval)
          $menu .= '<li><a href="#">...</a></li><li><a href="?' . $get . '&num='.$this->total.'" />'.$this->total.'</a></li>'; 
	  }
	  
	  //Находимся на одной из последних страниц с 1 по 5. Количество страниц больше 4
	  elseif (($this->page + ($interval - 1)) > $this->total && $this->total > ($interval - 1))
	  {
		if($this->total > $interval)
		$menu .= '<li><a href="?' . $get . '&num=1" />1</a></li><li><a href="#">...</a></li>'; 	    
		
		for ($i = ($this->total - ($interval - 1)); $i < ($this->total + 1); $i++) 
		{
          if($this->page == $i) 
            $menu .= '<li class="active"><a href="#">'.$i.'</a></li>';
          else  
            $menu .= '<li><a href="?' . $get . '&num='.$i.'" />'.$i.'</a></li>'; 
		} 		  
	  }	  
 	  //Находимся на страницах с 1 по 5. Количество страниц меньше 5
	  elseif ($this->page < $interval)
      {
        for ($i = 1; $i <= $this->total; $i++) 
        { 		
          if ($this->page == $i) 
            $menu .= '<li class="active"><a href="#">'.$i.'</a></li>';
          else  
            $menu .= '<li><a href="?' . $get . '&num='.$i.'" />'.$i.'</a></li>'; 
		}
	  }
	  //Находимся в середине стало быть
	  else
      {
		$menu .= '<li><a href="?' . $get . '&num=1" />1</a></li><li><a href="#">...</a></li>';
			
		for ($i = $this->page - ceil($interval / 2); $i <= $this->page + ceil($interval / 2); $i++) 
        { 		    
		  if($this->page == $i) 
            $menu .= '<li class="active"><a href="#">'.$i.'</a></li>';
          else  
            $menu .= '<li><a href="?' . $get . '&num='.$i.'" />'.$i.'</a></li>'; 
        }
        $menu .= '<li><a href="#">...</a></li><li><a href="?' . $get . '&num='.$this->total.'" />'.$this->total.'</a></li>'; 
	  }  
	  
      return $menu; 
    } 	  	    
  }
  
  
  
