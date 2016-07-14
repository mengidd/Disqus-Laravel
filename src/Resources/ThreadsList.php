<?php

namespace Mengidd\Disqus\Resources;

class ThreadsList extends Resource
{
    /**
     * Sets the category parameter
     *
     * @param $value
     * @return $this
     */
    public function category($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->parameters['category'] = $value;

        return $this;
    }

    /**
     * Sets the forum parameter
     *
     * @param $value
     * @return $this
     */
    public function forum($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->parameters['forum'] = $value;

        return $this;
    }

    /**
     * Sets the thread parameter
     *
     * @param $value
     * @return $this
     */
    public function thread($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->parameters['thread'] = $value;

        return $this;
    }

    /**
     * Sets the author parameter
     *
     * @param $value
     * @return $this
     */
    public function author($value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $this->parameters['author'] = $value;

        return $this;
    }

    /**
     * Sets the since parameter, supports DateTime and UNIX timestamps
     *
     * @param $value
     * @return $this
     */
    public function since($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp();
        }

        $this->parameters['since'] = $value;

        return $this;
    }

    /**
     * What relations to include (Choices: thread, forum)
     *
     * @param $related
     * @return $this
     */
    public function related(array $related)
    {
        $this->parameters['related'] = $related;

        return $this;
    }

    /**
     * Sets the attach parameter (Choices: topics)
     *
     * @param $attach
     * @return $this
     */
    public function attach(array $attach)
    {
        $this->parameters['attach'] = $attach;

        return $this;
    }

    /**
     * Limits the number of entries we will return
     *
     * @param int $limit
     * @return $this
     * @throws \Exception
     */
    public function limit($limit)
    {
        if ($limit > 100) {
            throw new \Exception('Disqus - Limit can\'t be higher than 100');
        }

        $this->parameters['limit'] = $limit;

        return $this;
    }

    /**
     * What threads to include (Choices: open, closed)
     *
     * @param $status
     * @return $this
     */
    public function includes(array $status)
    {
        $this->parameters['include'] = $status;

        return $this;
    }

    /**
     * Sets the order (Choices: asc, desc)
     *
     * @param $value
     * @return $this
     */
    public function order($value)
    {
        $this->parameters['order'] = $value;

        return $this;
    }
}
