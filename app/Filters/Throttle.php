<?php

namespace App\Filters;

use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Throttle implements FilterInterface
{
    /**
     * This is a demo implementation of using the Throttler class
     * to implement rate limiting for your application.
     *
     * @param list<string>|null $arguments
     *
     * @return ResponseInterface|void
     */
//    public function before(RequestInterface $request, $arguments = null)
//    {
//        $throttler = service('throttler');
//
//        // Restrict an IP address to no more than 1 request
//        // per second across the entire site.
//        if ($throttler->check(md5($request->getIPAddress()), 20, MINUTE) === false) {
//            return service('response')->setStatusCode(429);
//        }
//    }
    public function before(RequestInterface $request, $arguments = null)
    {
        $cache = Services::cache();

        $ip = $request->getIPAddress();
        $key = 'throttle_' . md5($ip);

        $limit   = $arguments[0] ?? 5;
        $minutes = $arguments[1] ?? 1;

        $count = $cache->get($key) ?? 0;

        if ($count >= $limit) {
            return service('response')
                ->setStatusCode(429)
                ->setBody('Too many requests');
        }

        $cache->save($key, $count + 1, $minutes * 60);
    }

    /**
     * We don't have anything to do here.
     *
     * @param list<string>|null $arguments
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}