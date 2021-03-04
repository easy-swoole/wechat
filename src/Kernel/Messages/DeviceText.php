<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class DeviceText extends Message
{
    protected $type = Message::DEVICE_TEXT;

    public function toXmlArray(): array
    {
        return [
            'DeviceType' => $this->get('device_type'),
            'DeviceID' => $this->get('device_id'),
            'SessionID' => $this->get('session_id'),
            'Content' => base64_encode($this->get('content')),
        ];
    }
}
