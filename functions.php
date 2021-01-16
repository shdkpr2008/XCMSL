<?php

	//Filename : functions.php
    //Description : Functions


    function get_apps($userid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT appid,appname,apppath FROM apps WHERE appid IN (select appid FROM appsusers WHERE userid = ?);');
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['appid']] = array("appname" => utf8_encode($row['appname']), "apppath" => utf8_encode($row['apppath']));
        }
        return $apps_ids=array_filter($rows);
    }

    function get_all_apps()
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT appid,appname,apppath FROM apps;');
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['appid']] = array("appname" => utf8_encode($row['appname']), "apppath" => utf8_encode($row['apppath']));
        }
        return $apps_ids=array_filter($rows);
    }

    function get_app_users($appid)
    {
        global $conn;
        $rows=array();
        $stmt = $conn->prepare('SELECT DISTINCT appsusers.userid, users.username FROM appsusers JOIN `users`ON (appsusers.`userid` = users.`userid`) WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['userid']] = $row['username'];
        }
        return $users_ids=array_filter($rows);
    }

    function get_app($appid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT appid,appname,apppath FROM apps WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['appid']] = array("appname" => utf8_encode($row['appname']), "apppath" => utf8_encode($row['apppath']));
        }
        return $app=array_filter($rows);
    }

    function get_app_config($appid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT prop,val FROM appconfig WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['prop']] = utf8_encode($row['val']);
        }
        return $appconf=$rows;
    }
    
    function get_app_progresscateg($appid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT categid,categname FROM appprogresscateg WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['categid']] = utf8_encode($row['categname']);
        }
        return $appprogresscateg=$rows;
    }

    function get_app_progress($categid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT progressid,team,title,percent,notes FROM appprogress WHERE categid = ?;');
        $stmt->bind_param('i', $categid);
        $stmt->execute();
        $result = $stmt->get_result();
       
        while ($row = $result->fetch_assoc()) {
            $rows[$row['progressid']] = array("team" => utf8_encode($row['team']), 
                                              "title" => utf8_encode($row['title']),
                                              "percent" => utf8_encode($row['percent']),
                                              "notes" => utf8_encode($row['notes']));
        }
        return $appprogress=$rows;
    }

    function add_app_progresscateg($appid, $categname)
    {
        global $conn;
       
        $stmt = $conn->prepare('INSERT INTO appprogresscateg (appid, categname) VALUES(?, ?);');
        $stmt->bind_param('is',$appid, $categname);
        if($stmt->execute())
            return $categid = $stmt->insert_id;
    }

    function remove_app_progresscateg($appid, $categid)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM appprogresscateg where appid = ? and categid = ?;');
        $stmt->bind_param('ii',$appid, $categid);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function remove_app_progress($progressid)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM appprogress where progressid = ?;');
        $stmt->bind_param('i', $progressid);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function get_app_tickets($appid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT ticketid,title,`status`,priority,category FROM tickets WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['ticketid']] = array("title" => utf8_encode($row['title']),
                                            "status" => utf8_encode($row['status']),
                                            "priority" => utf8_encode($row['priority']),
                                            "category" => utf8_encode($row['category']));
        }
        return $tickets=$rows;
    }

    function get_app_ticket($ticketid)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT title,`status`,priority,category FROM tickets WHERE ticketid = ?;');
        $stmt->bind_param('i', $ticketid);
        $stmt->execute();
        $result = $stmt->get_result();

        return $ticket = $result->fetch_assoc();
    }

    function get_app_ticket_messages($ticketid)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT messageid,`message`,`datetime`,username FROM `ticketmessages` as REFERRING LEFT JOIN `users` as REFERRED ON (REFERRING.`userid` = REFERRED.`userid`) WHERE ticketid = ?;');
        $stmt->bind_param('i', $ticketid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['messageid']] = array("username" => $row['username'], "message" => utf8_encode($row['message']), "datetime" => $row['datetime']);
        }
        return $messages=$rows;
    }
    function get_app_ticket_staff($ticketid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT DISTINCT ticketsstaff.userid, users.username FROM ticketsstaff JOIN `users`ON (ticketsstaff.`userid` = users.`userid`) WHERE ticketid = ?;');
        $stmt->bind_param('i', $ticketid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['userid']] = $row['username'];
        }
        return $staff_ids=array_filter($rows);
    }

    function get_app_staff_tickets($userid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT DISTINCT ticketid FROM ticketsstaff WHERE userid = ?;');
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row['ticketid'];
        }
        return $ticket_ids=array_filter($rows);
    }

    function update_app_ticket_staff($ticketid, $ticketstaff)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM ticketsstaff where ticketid = ?;');
        $stmt->bind_param('i',$ticketid);
        if(!$stmt->execute())
            return false;

        $ptmt = $conn->prepare('INSERT INTO ticketsstaff (ticketid, userid) VALUES (?, ?);');
        $ptmt ->bind_param("ii", $ticketid, $userid);

        foreach ($ticketstaff as $idx => $userid)
            if(!$ptmt->execute())
                return false;
        
        $ptmt->close();
        return true;
    }

    function update_app_ticket_status($ticketid, $status)
    {
        global $conn;

        $stmt = $conn->prepare('UPDATE tickets SET `status` = ? WHERE ticketid = ?;');
        $stmt->bind_param('si',$status, $ticketid);

        if($stmt->execute())
            return true;
        else
            return false;
    }

    function remove_app_ticket($ticketid)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM tickets where ticketid = ?;');
        $stmt->bind_param('i', $ticketid);
        
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function add_app_progress($categid)
    {
        global $conn;
        
        $stmt = $conn->prepare('INSERT INTO appprogress (categid) VALUES(?);');
        $stmt->bind_param('i', $categid);
        if($stmt->execute())
            return $progressid = $stmt->insert_id;
    }

    function add_app_ticket($appid, $ticket)
    {
        global $conn;
        global $userid;

        $stmt = $conn->prepare('INSERT INTO `tickets`(`appid`, `title`, `status`, `priority`, `category`) VALUES (?, ?, ?, ?, ?);');
        $stmt->bind_param('issss', $appid, $ticket["title"], $ticket["status"], $ticket["priority"], $ticket["category"]);
        if(!$stmt->execute())
            return false;

        $ticketid = $stmt->insert_id;
        if(!add_app_ticket_message($ticketid, $userid, $ticket["message"]))
            return false;
        return $ticketid;
    }

    function add_app_ticket_message($ticketid, $userid, $message)
    {
        global $conn;
        
        $stmt = $conn->prepare('INSERT INTO `ticketmessages`(`ticketid`, `userid`, `message`) VALUES (?, ?, ?);');
        $stmt->bind_param('iis', $ticketid, $userid, $message);
        if($stmt->execute())
            return $messageid = $stmt->insert_id;
        return false;
    }

    function update_app_progress($categid, $progressarr)
    {
        global $conn;

        $ptmt = $conn->prepare('UPDATE appprogress SET team = ?, title = ?, percent = ?, notes = ? WHERE progressid = ?');
        $ptmt ->bind_param("ssssi", $team, $title, $percent, $notes, $progressid);

        foreach ($progressarr as $progressid => $data) {
            $team = $data[0];
            $title = $data[1];
            $percent = $data[2];
            $notes = $data[3];

            if(!$ptmt->execute())
                return false;
        }
        $ptmt->close();
        return true;
    }

    function update_app_config($appid, $app_info)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM appconfig where appid = ?;');
        $stmt->bind_param('i',$appid);
        if(!$stmt->execute())
            return false;

        $ptmt = $conn->prepare('INSERT INTO appconfig (appid, prop, val) VALUES (?, ?, ?);');
        $ptmt ->bind_param("iss", $appid, $prop, $val);

        foreach ($app_info as $prop => $val)
            if(!$ptmt->execute())
                return false;
        
        $ptmt->close();
        return true;
    }

    function get_app_info($appid)
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT appinfo FROM apps WHERE appid = ?;');
        $stmt->bind_param('i', $appid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc()["appinfo"];
    }

    function add_user($username, $password, $email)
    {
        global $conn;

        $stmt = $conn->prepare('INSERT INTO users (username, password, email) VALUES(?, ?, ?);');
        $stmt->bind_param('sss',$username, $password, $email);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function add_app($appname, $apppath, $appusers)
    {
        global $conn;
        $defappinfo = 'a:15:{s:6:"inicio";s:10:"inicio.xml";s:9:"conexión";s:13:"conectate.xml";s:7:"eventos";s:8:"blog.xml";s:8:"nosotros";s:12:"nosotros.xml";s:8:"contacto";s:12:"contacto.xml";s:9:"logo_left";s:16:"./img/logo_l.png";s:10:"logo_right";s:16:"./img/logo_r.png";s:3:"ios";s:0:"";s:7:"android";s:0:"";s:2:"fb";s:0:"";s:7:"twitter";s:0:"";s:7:"youtube";s:0:"";s:5:"insta";s:0:"";s:7:"applogo";s:0:"";s:8:"template";s:9:"template1";}';
        $app_info = unserialize($defappinfo);
        array_walk_recursive($app_info,'prepString');

        $defprogress = 'a:11:{s:9:"SITE DATA";a:8:{i:0;a:4:{i:0;s:4:"SD01";i:1;s:28:"ESTA EL SITE TITLE CORRECTO?";i:2;s:1:"0";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"SD02";i:1;s:31:"ESTA EL SITE TAG LINE CORRECTO?";i:2;s:1:"0";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"SD03";i:1;s:28:"ESTA EL PERMALINK CORRECTO? ";i:2;s:1:"0";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"SD04";i:1;s:46:"ESTA CON LA INFO DE COPYRIGHT Y HECHO EL LINK?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"SD05";i:1;s:71:"ESTA EL LOGOTIPO DE E2OUTLOOK EN LA SECCION DE COPYRIGHT A LA IZQUIERDA";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"SD06";i:1;s:49:"BASADO EN EL LOGO ESTA EL FAVICON LISTO Y SUBIDO?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:4:"SD07";i:1;s:27:"ESTA EL FAVICON ACTUALIZADO";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:4:"SD08";i:1;s:64:"ESTAN LOS ICONOS DE LAS REDES SOCIALES DE E2OUTLOOK A LA DERECHA";i:2;s:0:"";i:3;s:0:"";}}s:14:"REDES SOCIALES";a:8:{i:0;a:4:{i:0;s:4:"RS01";i:1;s:81:"FACEBOOK CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"RS02";i:1;s:80:"TWITTER CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"RS03";i:1;s:84:"GOOGLE PLUS CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"RS04";i:1;s:81:"LINKEDIN CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"RS05";i:1;s:82:"INSTAGRAM CREADO? INCLUYENDO IMAGENES DE PERFIL, BANNER E INFORMACION DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"RS06";i:1;s:33:"CUENTAS REGISTRADAS EN HOOTSUITE?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:4:"RS07";i:1;s:32:"DISEÑO GRAFICO DE BANNER LISTO?";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:4:"RS08";i:1;s:40:"DISEÑO GRAFICO DE FOTO DE PERFIL LISTO?";i:2;s:0:"";i:3;s:0:"";}}s:6:"HEADER";a:4:{i:0;a:4:{i:0;s:7:"HDR-001";i:1;s:26:"ESTA EL HEADER #14 PUESTO?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:7:"HDR-002";i:1;s:13:"LOGO #1 ESTA?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:7:"HDR-003";i:1;s:13:"LOGO #2 ESTA?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:7:"HDR-004";i:1;s:13:"LOGO #2 LINK?";i:2;s:0:"";i:3;s:0:"";}}s:4:"MENU";a:6:{i:0;a:4:{i:0;s:7:"MNU-001";i:1;s:30:"ESTA CREADO EL MENU PRINCIPAL?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:7:"MNU-002";i:1;s:33:"ASIGNARON EL HOME PAGE EN SETTING";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:7:"MNU-003";i:1;s:33:"TODAS LAS PAGINAS FUERON CREADAS?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:7:"MNU-004";i:1;s:35:"ESTA LAS REDES SOCIALES EN EL MENU?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:7:"MNU-005";i:1;s:59:"ESTAN LAS REDES LINKED EN EL MENU A SUS PAGINAS APROPIADAS?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:7:"MNU-006";i:1;s:39:"HICIERON COMBINACION DE COLORES AL MENU";i:2;s:0:"";i:3;s:0:"";}}s:7:"SLIDERS";a:5:{i:0;a:4:{i:0;s:4:"SL01";i:1;s:41:"HICIERON LOS 5 SLIDERS - DISEÑO GRAFICO?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"SL02";i:1;s:33:"HICIERON LINK A TODOS LOS SLIDERS";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"SL03";i:1;s:49:"HICIERON QUE DEN VUELTA LOS SLIDERS ELLOS MISMOS?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"SL04";i:1;s:31:"HAY LAS FLECHAS EN LOS SLIDERS?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"SL05";i:1;s:50:"SE VEN BIEN LOS SLIDER PROPORCIONAL CON LA PAGINA?";i:2;s:0:"";i:3;s:0:"";}}s:12:"CUERPO TEXTO";a:13:{i:0;a:4:{i:0;s:4:"CT01";i:1;s:49:"INSTALARON USE THIS FONT? Y PUSIERON LA LICENCIA?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"CT02";i:1;s:30:"ASIGNARON UN TEXTO A HEADINGS?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"CT03";i:1;s:49:"ASIGNARON UN TEXTO ESPECIAL A TEXTO DE PARAGRAPH?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"CT04";i:1;s:46:"LOS COLORES DE LOS LINKS COMBINAN CON EL LOGO?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"CT05";i:1;s:33:"LE AJUSTARON EL TAMAÑO AL TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"CT06";i:1;s:53:"TODAS LAS PAGINAS TIENEN UN DISEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:0:"";i:1;s:39:"PAGINA INICIO DISEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:0:"";i:1;s:46:"PAGINA QUIENES SOMOS DESEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:8;a:4:{i:0;s:0:"";i:1;s:43:"PAGINA LA EMPRESA DISEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:9;a:4:{i:0;s:0:"";i:1;s:42:"PAGINA SERVICIOS DISEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:10;a:4:{i:0;s:0:"";i:1;s:42:"PAGINA PRODUCTOS DESEÑO COMPLETO Y TEXTO?";i:2;s:0:"";i:3;s:0:"";}i:11;a:4:{i:0;s:0:"";i:1;s:42:"PAGINA CONTACT US DISEÑO COMPLETO Y TEXTO";i:2;s:0:"";i:3;s:0:"";}i:12;a:4:{i:0;s:0:"";i:1;s:35:"ENCONTRARON LINKS QUE NO FUNCIONAN?";i:2;s:0:"";i:3;s:0:"";}}s:11:"FORMULARIOS";a:6:{i:0;a:4:{i:0;s:4:"FM01";i:1;s:36:"INSTALARON EL PLUGIN DE FORMULARIOS?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"FM02";i:1;s:47:"EL FORMULARIO TIENE LICENCIA? ESTA ACTUALIZADO?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"FM03";i:1;s:35:"HICIERON EL FORMULARIO DE CONTACTO?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"FM04";i:1;s:78:"SIGUIERON EL FORMATO DE NOMBRAR LOS FORMULARIOS? (NOMBREDEFORMULARIO_PROYECTO)";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"FM05";i:1;s:42:"LOS BOTONES ESTAN DEL MISMO COLOR AL LOGO?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"FM06";i:1;s:27:"FUNCIONAN TODOS LOS BOTONES";i:2;s:0:"";i:3;s:0:"";}}s:13:"THEME OPTIONS";a:7:{i:0;a:4:{i:0;s:8:"THOP-001";i:1;s:27:"DESHABILITARON BREADCRUMBS?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:8:"THOP-002";i:1;s:27:"ESTA EL HEADER 14 ACTIVADO?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:8:"THOP-003";i:1;s:29:"EL BODY WRAPPER ESTA EN FULL?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:8:"THOP-004";i:1;s:37:"ESTA EL WIDTH DE LOGO EN GENERAL 375?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:8:"THOP-005";i:1;s:40:"ESTA DESHABILITADO LA OPCION DE SIDEBAR?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:8:"THOP-006";i:1;s:49:"ESTA POST>SINGLE POST, PAGE LAYOUT EN FULL WIDTH?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:8:"THOP-007";i:1;s:45:"ESTA POST>SINGLE POST, POST LAYOUT EN MEDIUM?";i:2;s:0:"";i:3;s:0:"";}}s:7:"PLUGINS";a:14:{i:0;a:4:{i:0;s:4:"PG01";i:1;s:24:"SE INSTALO USE ANY FONT?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"PG02";i:1;s:27:"SE INSTALO SIMPLE LIGHTBOX?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"PG03";i:1;s:35:"SE INSTALO EL ULTIMO MASTER SLIDER?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"PG04";i:1;s:33:"SE INSTALO EL ULTIMO PORTO THEME?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"PG05";i:1;s:28:"SE INSTALO EL PORTO WIDGETS?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"PG06";i:1;s:41:"SE INSTALO EL ULTIMO PORTO CONTENT TYPES?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:4:"PG07";i:1;s:47:"SE INSTALO EL ULTIMO WP BAKERY VISUAL COMPOSER?";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:4:"PG08";i:1;s:51:"SE INSTALO EL ULTIMATE ADD-ONS FOR VISUAL COMPOSER?";i:2;s:0:"";i:3;s:0:"";}i:8;a:4:{i:0;s:4:"PG09";i:1;s:30:"SE INSTALO EL ULTIMO MANAGEWP?";i:2;s:0:"";i:3;s:0:"";}i:9;a:4:{i:0;s:4:"PG10";i:1;s:35:"SE INSTALO EL ULTIMO GRAVITY FORMS?";i:2;s:0:"";i:3;s:0:"";}i:10;a:4:{i:0;s:4:"PG11";i:1;s:29:"SE INSTALO EL ULTIMO AKISMET?";i:2;s:0:"";i:3;s:0:"";}i:11;a:4:{i:0;s:4:"PG12";i:1;s:44:"SE INSTALO EL ULTIMO DYNAMIC FEATURED IMAGE?";i:2;s:0:"";i:3;s:0:"";}i:12;a:4:{i:0;s:4:"PG13";i:1;s:28:"SE INSTALO Y ACTIVO JETPACK?";i:2;s:0:"";i:3;s:0:"";}i:13;a:4:{i:0;s:4:"PG14";i:1;s:45:"SE REVISO QUE LOS COMENTARIOS ESTEN BORRADOS?";i:2;s:0:"";i:3;s:0:"";}}s:6:"FOOTER";a:9:{i:0;a:4:{i:0;s:4:"FT01";i:1;s:16:"FOOTER COMPLETO?";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:4:"FT02";i:1;s:19:"FOOTER #1- ÁREA 1?";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:4:"FT03";i:1;s:19:"FOOTER #1- ÁREA 2?";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:4:"FT04";i:1;s:19:"FOOTER #1- ÁREA 3?";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:4:"FT05";i:1;s:19:"FOOTER #1- ÁREA 4?";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:4:"FT06";i:1;s:50:"ESTA TODO EL TEXTO EN EL MISMO COLOR EN EL FOOTER?";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:4:"FT07";i:1;s:54:"ESTA EL FOOTER EL MISMO COLOR A LA IMAGEN COOPERATIVO?";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:4:"FT08";i:1;s:69:"ESTA LAS REDES SOCIALES DEL CLIENTE CON ICONOS ESTANDAR EN EL FOOTER?";i:2;s:0:"";i:3;s:0:"";}i:8;a:4:{i:0;s:4:"FT09";i:1;s:94:"ESTAN LAS REDES SOCIALES DEL CLIENTE / E2OUTLOOK LINKED EN EL FOOTER A SUS PAGINAS APROPIADAS?";i:2;s:0:"";i:3;s:0:"";}}s:6:"CLIENT";a:30:{i:0;a:4:{i:0;s:0:"";i:1;s:22:"NOMBRE DE LA COMPAÑIA";i:2;s:0:"";i:3;s:0:"";}i:1;a:4:{i:0;s:0:"";i:1;s:15:"AREA DE NEGOCIO";i:2;s:0:"";i:3;s:0:"";}i:2;a:4:{i:0;s:0:"";i:1;s:9:"DIRECCION";i:2;s:0:"";i:3;s:0:"";}i:3;a:4:{i:0;s:0:"";i:1;s:6:"E-MAIL";i:2;s:0:"";i:3;s:0:"";}i:4;a:4:{i:0;s:0:"";i:1;s:8:"TELEFONO";i:2;s:0:"";i:3;s:0:"";}i:5;a:4:{i:0;s:0:"";i:1;s:18:"HORARIO DE TRABAJO";i:2;s:0:"";i:3;s:0:"";}i:6;a:4:{i:0;s:0:"";i:1;s:7:"MANAGER";i:2;s:0:"";i:3;s:0:"";}i:7;a:4:{i:0;s:0:"";i:1;s:17:"AREA DE UBICACION";i:2;s:0:"";i:3;s:0:"";}i:8;a:4:{i:0;s:0:"";i:1;s:6:"CIUDAD";i:2;s:0:"";i:3;s:0:"";}i:9;a:4:{i:0;s:0:"";i:1;s:31:"AÑO DE FUNDACION DE LA EMPRESA";i:2;s:0:"";i:3;s:0:"";}i:10;a:4:{i:0;s:0:"";i:1;s:38:"DOMINIO SELECCIONADO PARA NUEVA PAGINA";i:2;s:0:"";i:3;s:0:"";}i:11;a:4:{i:0;s:0:"";i:1;s:9:"SERVICIOS";i:2;s:0:"";i:3;s:0:"";}i:12;a:4:{i:0;s:0:"";i:1;s:6:"NOMBRE";i:2;s:0:"";i:3;s:0:"";}i:13;a:4:{i:0;s:0:"";i:1;s:18:"NUMERO DE TELEFONO";i:2;s:0:"";i:3;s:0:"";}i:14;a:4:{i:0;s:0:"";i:1;s:6:"E-MAIL";i:2;s:0:"";i:3;s:0:"";}i:15;a:4:{i:0;s:0:"";i:1;s:19:"IDIOMA DE LA PAGINA";i:2;s:0:"";i:3;s:0:"";}i:16;a:4:{i:0;s:0:"";i:1;s:15:"PAGINAS DE MENU";i:2;s:0:"";i:3;s:0:"";}i:17;a:4:{i:0;s:0:"";i:1;s:21:"SUBPAGINAS DE SUBMENU";i:2;s:0:"";i:3;s:0:"";}i:18;a:4:{i:0;s:0:"";i:1;s:6:"SLOGAN";i:2;s:0:"";i:3;s:0:"";}i:19;a:4:{i:0;s:0:"";i:1;s:5:"LOGO1";i:2;s:0:"";i:3;s:0:"";}i:20;a:4:{i:0;s:0:"";i:1;s:16:"COLORES DEL LOGO";i:2;s:0:"";i:3;s:0:"";}i:21;a:4:{i:0;s:0:"";i:1;s:12:"COLOR PAGINA";i:2;s:0:"";i:3;s:0:"";}i:22;a:4:{i:0;s:0:"";i:1;s:8:"HISTORIA";i:2;s:0:"";i:3;s:0:"";}i:23;a:4:{i:0;s:0:"";i:1;s:12:"BIBLIOGRAFIA";i:2;s:0:"";i:3;s:0:"";}i:24;a:4:{i:0;s:0:"";i:1;s:5:"FOTOS";i:2;s:0:"";i:3;s:0:"";}i:25;a:4:{i:0;s:0:"";i:1;s:32:"QUE QUIERE RESALTAR DE LA PAGINA";i:2;s:0:"";i:3;s:0:"";}i:26;a:4:{i:0;s:0:"";i:1;s:21:"PAGINAS DE REFERENCIA";i:2;s:0:"";i:3;s:0:"";}i:27;a:4:{i:0;s:0:"";i:1;s:17:"GALERÍA DE FOTOS";i:2;s:0:"";i:3;s:0:"";}i:28;a:4:{i:0;s:0:"";i:1;s:26:"CREACION DE REDES SOCIALES";i:2;s:0:"";i:3;s:0:"";}i:29;a:4:{i:0;s:0:"";i:1;s:44:"PUBLICACIONES A CARGAR EN LAS REDES SOCIALES";i:2;s:0:"";i:3;s:0:"";}}}';
        $progress = unserialize($defprogress);
        array_walk_recursive($progress,'prepString');

        $stmt = $conn->prepare('INSERT INTO apps (appname, apppath) VALUES(?, ?);');
        $stmt->bind_param('ss',$appname, $apppath);
        if(!$stmt->execute())
            return false;
        $appid = $stmt->insert_id;

        $ptmt = $conn->prepare('INSERT INTO appconfig (appid, prop, val) VALUES (?, ?, ?);');
        $ptmt ->bind_param("iss", $appid, $prop, $val);

        foreach ($app_info as $prop => $val)
            if(!$ptmt->execute())
                return false;
        
        $ptmt = $conn->prepare('INSERT INTO appprogresscateg (appid, categname) VALUES (?, ?);');
        $ptmt ->bind_param("is", $appid, $categ);

        foreach ($progress as $categ => $progarr) {
            if(!$ptmt->execute())
                    return false;

            $categid = $ptmt->insert_id;
            $sptmt = $conn->prepare('INSERT INTO appprogress (categid, team, title, percent, notes) VALUES (?, ?, ?, ?, ?);');
            $sptmt ->bind_param("issss", $categid, $team, $title, $percent, $notes);

            foreach ($progarr as $index => $data) {
                $team = $data[0];
                $title = $data[1];
                $percent = $data[2];
                $notes = $data[3];

                if(!$sptmt->execute())
                    return false;
            }
            $sptmt->close();
        }

        $ptmt = $conn->prepare('INSERT INTO appsusers (appid, userid) VALUES (?, ?);');
        $ptmt ->bind_param("ii", $appid, $userid);

        foreach ($appusers as $idx => $userid)
            if(!$ptmt->execute())
                return false;
        
        $ptmt->close();
        return true;
    }

    function update_app($appid, $appusers)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM appsusers where appid = ?;');
        $stmt->bind_param('i',$appid);
        if(!$stmt->execute())
            return false;

        $ptmt = $conn->prepare('INSERT INTO appsusers (appid, userid) VALUES (?, ?);');
        $ptmt ->bind_param("ii", $appid, $userid);

        foreach ($appusers as $idx => $userid)
            if(!$ptmt->execute())
                return false;
        
        $ptmt->close();
        return true;
    }

    function remove_user($userid)
    {
        global $conn;

        if($userid == 1)
            return false;

        $stmt = $conn->prepare('DELETE FROM users where userid = ?;');
        $stmt->bind_param('i',$userid);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function remove_app($appid)
    {
        global $conn;

        $stmt = $conn->prepare('DELETE FROM apps where appid = ?;');
        $stmt->bind_param('i',$appid);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function update_user($username, $password, $email, $userid)
    {
        global $conn;

        $stmt = $conn->prepare('UPDATE users SET username = ?, password = ?, email = ? where userid = ?;');
        $stmt->bind_param('sssi',$username, $password, $email, $userid);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    function get_users()
    {
        global $conn;
        $rows=array();
        
        $stmt = $conn->prepare('SELECT userid,username,email FROM users;');
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $rows[$row['userid']] = array("username" => $row['username'], "email" => $row['email']);
        }
        return $users=array_filter($rows);
    }

    function get_passhash($username)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT password FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row["password"];
    }

    function get_userid($username)
    {
        global $conn;
        
        $stmt = $conn->prepare('SELECT userid FROM users WHERE username = ?;');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row["userid"];
    }

    function get_username($userid)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT username FROM users WHERE userid = ?');
        $stmt->bind_param('i', $userid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row["username"];
    }

    function get_useridfe($email)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT userid FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row["userid"];
    }

    function verify_reset($key, $reset)
    {
        global $conn;

        $stmt = $conn->prepare('SELECT `email`,`password` FROM users WHERE md5(email) = ? AND md5(`password`) = ?');
        $stmt->bind_param('ss', $key,$reset);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_num_rows($result);
    }

    function password_reset($hash, $key, $reset)
    {
        global $conn;       

        $stmt = $conn->prepare('UPDATE users SET `password` = ? WHERE md5(email) = ? AND md5(password) = ?');
        $stmt->bind_param('sss', $hash, $key, $reset);
        $stmt->execute();
        return mysqli_affected_rows($conn);
    }
    
	function prepString(&$item, $key) {
		$item = htmlentities($item);
	}
    
    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    } //https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
    
    function in_array_r($item , $array){
        return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
    }

?>