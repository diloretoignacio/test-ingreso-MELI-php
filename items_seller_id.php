<?php
    //Funcion encargada de buscar el nombre de la categoria segun un ID
    function nombre_categoria($category_id)
    {
        $json_category = file_get_contents("https://api.mercadolibre.com/categories/".$category_id);
        $array_category = json_decode($json_category, true);
        return $array_category['name'];
    }

    //Funcion encargada de Buscar los datos de un respectivo seller ID
    function buscar_datos($seller_id)
    {
        $json_respopnse = file_get_contents('https://api.mercadolibre.com/sites/MLA/search?seller_id='.$seller_id);
        $array = json_decode($json_respopnse, true);
        $resultados = $array['results'];
        return $resultados;
    }

    //Funcion que crea un log con datos obtenidos previamente 
    function crear_log($datos, $seller_id)
    {
        if (!empty($datos))
        {
            $archivo = fopen('log_'.$seller_id.'.txt','w');
            foreach ($datos as $item) 
            {
                $id = $item['id'];
                $title = $item['title'];
                $category_id =$item['category_id'];        
                $category_name = nombre_categoria($category_id);
                
                fputs($archivo, "ID: ".$id."\n");
                fputs($archivo, "Title: ".$title."\n");
                fputs($archivo, "Category ID: ".$category_id."\n");
                fputs($archivo, "Category name: ".$category_name."\n\n");

            }
            fclose($archivo);
        }
    }
    

    //Array que debe contener cada uno de los ID_SELLER a buscar
    $sellers_id = [179571326];
    
    foreach ($sellers_id as $seller_id)
    {
        $datos = buscar_datos($seller_id);
        crear_log($datos, $seller_id);
    }
    



    

    

    
?>