<?php

namespace Mengidd\Disqus\Resources;

class PostsList extends Resource
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
     * Sets the end parameter, supports DateTime and UNIX timestamps
     *
     * @param $value
     * @return $this
     */
    public function end($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp();
        }

        $this->parameters['end'] = $value;

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
     * Sets the start parameter, supports DateTime and UNIX timestamps
     *
     * @param $value
     * @return $this
     */
    public function start($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->getTimestamp();
        }

        $this->parameters['start'] = $value;

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
     * The number of entries we want to skip
     *
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->parameters['offset'] = $offset;

        return $this;
    }

    /**
     * What posts to include (Choices: unapproved, approved, spam, deleted, flagged, highlighted)
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
