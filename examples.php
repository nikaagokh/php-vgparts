<?php


//User::loginUser($user);
//User::registerUser($user);
//Auth::loginUser($user);
//Auth::registerUser($user);
//Auth::loginUser($user);
//$otpUser = (new OtpUser(13, $user['firstName'], $user['lastName'], $user['email'], $user['password']))->toArray();

//$changed = Database::insertRow('otp_user', $user);
//authenticate();
//$changed = Database::updateRow('sessions', $object, ['id' => 1]);
//$changed = Database::upsertRow('sessions', $object, ['id' => 11]);

/*
            
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                $middlewares = $route['middlewares'];
                foreach($middlewares as $middleware) {
                    $midd = 'Core\\' .$middleware;
                    if(function_exists($midd)) {
                        $midd();
                    } 
                }
                
                $controller = $route['controller'];
                if (is_array($controller) && count($controller) === 2) {
                    [$class, $action] = $controller;
                    $exists = class_exists($class);
                    if (class_exists($class) && method_exists($class, $action)) {
                        call_user_func([$class, $action]);
                        return;
                    }
                } else {
                    return require base_path('/src/controllers/' . $controller);
                }
                
            }
            */
            