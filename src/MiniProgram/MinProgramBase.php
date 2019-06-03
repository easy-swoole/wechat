<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Exception\MiniProgramError;

class MinProgramBase
{
    private $miniProgram;

    /**
     * MinProgramBase constructor.
     *
     * @param MiniProgram $miniProgram
     */
    public function __construct(MiniProgram $miniProgram)
    {
        $this->miniProgram = $miniProgram;;
    }

    /**
     * getMiniProgram
     *
     * @return MiniProgram
     */
    public function getMiniProgram(): MiniProgram
    {
        return $this->miniProgram;
    }

    /**
     * hasException
     *
     * @param array $response
     * @return array
     * @throws MiniProgramError
     */
    protected function hasException(array $response)
    {
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }
}