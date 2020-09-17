<?php
/**
 * PDOx - Useful Query Builder & PDO Class & Memcached
 *
 * @class    CacheMem
 * @author   KaraKunT
 * @web      <https://www.karakunt.com>
 * @url      <https://github.com/KaraKunT/pdox>
 * @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
 */

namespace Buki;

use Memcached;

class CacheMem
{
    protected $cacheDir = null;
    protected $cache = null;
    protected $finish = null;

    protected $memcached = null;

    /**
     * Cache constructor.
     *
     * @param null $dir
     * @param int  $time
     */
    function __construct($dir = null, $time = 0)
    {
        $this->cacheDir = $dir;
        $this->cache = $time;
        $this->finish = time() + $time;

        $this->memcached = new Memcached;
        $this->memcached->addServer('localhost', 11211);     
    }

    /**
     * @param      $sql
     * @param bool $array
     *
     * @return bool|void
     */
    public function getCache($sql, $array = false)
    {
        
        if (is_null($this->cache)) {
            return false;
        }

        if (($cache = $this->memcached->get($this->keyName($sql)))) {
            if($this->memcached->getResultCode() == Memcached::RES_SUCCESS){
                $cache = json_decode($cache, $array);
                return ($array ? $cache['data'] : $cache->data);
            }
        }              

        return false;
    }

    /**
     * @param $sql
     * @param $result
     *
     * @return bool|void
     */
    public function setCache($sql, $result)
    {
        if (is_null($this->cache)) {
            return false;
        }

        $this->memcached->set($this->keyName($sql), json_encode(['data' => $result, 'finish' => $this->finish]), $this->finish);

        return;
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function keyName($name)
    {
        return md5($this->cacheDir.':'.$name);
    }
}
