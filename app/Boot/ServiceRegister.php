<?php
/**
 * Created by PhpStorm.
 * User: Zou
 * Date: 2019/1/15
 * Time: 9:35
 *
 * 注册类，提供相关服务的注册方法
 */

namespace App\Boot;


use Core\Cache;
use Core\Container;
use Core\Dispatcher;
use Core\Memcache;
use Core\Model;
use Core\Redis;
use Core\Router;
use Curl\Curl;

class ServiceRegister
{
    private $container = null;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /* -----------------------------------------
     * 绑定框架核心类到容器中
     * -----------------------------------------
     */
    public function registerCoreService()
    {
        $this->container->bindWithArray([
            Cache::class => Cache::class,
            Dispatcher::class => Dispatcher::class,
            Memcache::class => Memcache::class,
            Redis::class => Redis::class,
            Router::class => Router::class,
            'Utils\\IdGenerateModel' => function() {
                return new Model('id_generate', ' ');
            }
        ]);
    }

    /* --------------------------------------
     * 绑定用户服务
     * --------------------------------------
     */
    public function registerUserService()
    {
        $this->container->bindWithArray(
            [
                Curl::class => function() {
                    return new Curl();
                }
            ],
            [
                Curl::class => true
            ]
        );
    }

}