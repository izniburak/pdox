<?php

/**
 * PDOx - Useful Query Builder & PDO Class
 *
 * @class    CacheMem
 * @author   Şükrü Kansız
 * @web      <http://burakdemirtas.org>
 * @url      <https://github.com/izniburak/PDOx>
 * @license  The MIT License (MIT) - <http://opensource.org/licenses/MIT>
 */

namespace Buki;

use Memcached;

class CacheMem
{
    protected $masterKey = null;
    protected $cache = null;
    protected $finish = null;

    protected $memcached = null;

    /**
     * CacheMem constructor.
     *
     * @param null $config
     */
    function __construct($config = [])
    {
        $this->masterKey = $config['masterkey'];
        $this->memcached = new Memcached();
        $this->memcached->addServer($config['host'], $config['port']);
    }

    /**
     * @param int  $time
     */
    public function setCacheTime($time = 0)
    {
        $this->cache = $time;
        $this->finish = time() + $time;
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
            if ($this->memcached->getResultCode() == Memcached::RES_SUCCESS) {
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
     * @param $masterKey
     *
     * @return array
     */
    public function clearCache($masterKey)
    {
        $data = null;
        $keys = $this->memcached->getAllKeys();
        foreach ($keys as $item) {
            if (preg_match('/' . $masterKey . '.PDOx.*/', $item)) {
                $this->memcached->delete($item);
                $data[] = $item;
            }
        }
        return is_array($data) ? $data : null;
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function keyName($name)
    {
        return $this->masterKey . '.PDOx.' . md5($this->masterKey . ':' . $name);
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        if (!is_null($this->memcached)) {
            $this->memcached->quit();
        }
    }
}
