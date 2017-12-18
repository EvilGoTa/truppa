<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.11.2017
 * Time: 23:36
 */

class truppaEvent implements ArrayAccess
{
    protected $id;
    protected $data;
    protected $errors;
    protected $valid = false;
    protected $model;
    protected $stuff;
    protected $mParticipation;

    public function __construct($data)
    {
        $this->model = new truppaEventModel();
        $this->stuff = new truppaEventStuffModel();
        $this->mParticipation = new truppaEventStuffParticipationModel();

        if (is_array($data)) {
            if ($this->validate($data)) {
                $data['contact_id'] = wa()->getUser()->getId();
                $this->data = $data;
            }
        } else {
            $this->load($data);
        }

    }

    public function load($url)
    {
        $this->data = $this->model->getByField('url', $url);
        $this->id = $this->data['id'];
        $this->data['description'] = truppaBBcode::bbcode_to_html($this->data['description']);
        $this->data['stuff'] = $this->stuff->getByField('event_id', $this->id, true);
        foreach ($this->data['stuff'] as $key => $stuff) {
            $this->data['stuff'][$key]['participants'] = $this->mParticipation->getById($stuff['id']);
        }
        $this->data['participants'] = $this->mParticipation->getParticipationContacts($this->id);
    }

    public function save()
    {
        $model = new truppaEventModel();

        $this->data['url'] = $this->generate_url($this->data['name']);

        $deadline_ar = explode(' ', $this->data['deadline']);
        $deadline_date_ar = explode('.', $deadline_ar[0]);
        $this->data['deadline'] = "{$deadline_date_ar[2]}-{$deadline_date_ar[1]}-{$deadline_date_ar[0]} {$deadline_ar[1]}";

        $this->id = $model->insert($this->data);
//        wa_dump($this->data);
        foreach ($this->data['stuff']['name'] as $key => $stuff) {
            $stuff = trim($stuff);
            if (!empty($stuff)) {
                $model->addStuff(
                    array(
                        'event_id' => $this->id,
                        'name' => $stuff,
                        'count' => $this->data['stuff']['count'][$key]
                    )
                );
            }
        }


    }

    public function isParticipant($contact_id)
    {
        $participation = $this->mParticipation->getParticipation($this->id, $contact_id);
        return $participation;
    }

    public function addStuff($s_id, $s_count, $contact_id)
    {
        $this->mParticipation->insert(array(
            'stuff_id' => $s_id,
            'contact_id' => $contact_id,
            'count' => $s_count,
            'approved' => 0,
        ));
    }

    private function generate_url($name)
    {
        $model = new truppaEventModel();
        $url = waLocale::transliterate($name);
        $url = str_replace(' ', '_', $url);
        $url = preg_replace('/[^a-zA-Z0-9_-]+/', '', $url);
        $salt = '';
        do {
            if (isset($count)) {
                $salt = '_'.rand(1000, 9999);
            }
            $count = $model->select('COUNT(*)')->where("url = '$url$salt'")->fetch();
        } while ($count['COUNT(*)'] > 0);
        return $url.$salt;
    }

    private function getStuffIds($forIN = false)
    {
        $result = [];
        $stuff_ids = $this->stuff->getByField('event_id', $this->id, true);
        foreach ($stuff_ids as $si) {
            $result[] = $si['id'];
        }
        if (count($result) == 0 && $forIN) {
            return [0];
        }
        return $result;
    }

    private function validate($data)
    {
        // TODO validation...
        $this->valid = true;
        $this->errors = array();
        return true;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}