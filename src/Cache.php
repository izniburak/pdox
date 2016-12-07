<?php
/*
*
* @ Package: PDOx - Useful Query Builder & PDO Class
* @ Class: Cache
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
* @ Web: http://burakdemirtas.org
* @ URL: https://github.com/izniburak/PDOx
* @ Licence: The MIT License (MIT) - Copyright (c) - http://opensource.org/licenses/MIT
*
*/

namespace Buki;

class Cache
{
  private $cacheDir = null;
  private $cache    = null;
  private $finish   = null;

  function __construct($dir = null, $time = 0)
  {
    if(!file_exists($dir))
            mkdir($dir, 0755);

    $this->cacheDir = $dir;
    $this->cache = $time;
    $this->finish = time() + $time;
  }

  public function setCache($sql, $result)
  {
    if (is_null($this->cache))
      return false;

    $cacheFile = $this->cacheDir . $this->fileName($sql) . '.cache';
    $cacheFile = fopen($cacheFile, 'w');

    if($cacheFile)
      fputs($cacheFile, json_encode(["data" => $result, "finish" => $this->finish]));

    return;
  }

  public function getCache($sql, $array = false)
  {
    if (is_null($this->cache))
      return false;

    $cacheFile = $this->cacheDir . $this->fileName($sql) . ".cache";

    if (file_exists($cacheFile))
    {
      $cache = json_decode(file_get_contents($cacheFile), $array);

      if (($array ? $cache["finish"] : $cache->finish) < time())
      {
        unlink($cacheFile);
        return;
      }
      else
        return ($array ? $cache["data"] : $cache->data);
    }

    return false;
  }

  private function fileName($name)
  {
    return md5($name);
  }
}
