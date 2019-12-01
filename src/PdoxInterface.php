<?php

namespace Buki;

interface PdoxInterface
{
    /**
     * @param null $type
     * @param null $argument
     *
     * @return mixed
     */
    public function get($type = null, $argument = null);

    /**
     * @param null $type
     * @param null $argument
     *
     * @return mixed
     */
    public function getAll($type = null, $argument = null);

    /**
     * @param array $data
     * @param bool  $type
     *
     * @return mixed
     */
    public function update(array $data, $type = false);

    /**
     * @param array $data
     * @param bool  $type
     *
     * @return mixed
     */
    public function insert(array $data, $type = false);

    /**
     * @param bool $type
     *
     * @return mixed
     */
    public function delete($type = false);
}
