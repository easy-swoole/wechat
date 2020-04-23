<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/21
 * Time: 22:16
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\NetWork;

class Comment extends OfficialAccountBase
{
    /**
     * 删除回复
     *
     * @param     $msgDataId
     * @param     $userCommentId
     * @param     $content
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function deleteReply($msgDataId, $userCommentId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_REPLY_DELETE, [
            'msg_data_id'     => $msgDataId,
            'index'           => $index,
            'user_comment_id' => $userCommentId
        ]);
    }

    /**
     * 回复评论
     *
     * @param     $msgDataId
     * @param     $userCommentId
     * @param     $content
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function reply($msgDataId, $userCommentId, $content, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_REPLY_ADD, [
            'msg_data_id'     => $msgDataId,
            'index'           => $index,
            'user_comment_id' => $userCommentId,
            'content'         => $content
        ]);
    }

    /**
     * 删除评论
     *
     * @param     $msgDataId
     * @param     $userCommentId
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function delete($msgDataId, $userCommentId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_DELETE, [
            'msg_data_id'     => $msgDataId,
            'index'           => $index,
            'user_comment_id' => $userCommentId
        ]);
    }

    /**
     * 将评论取消精选
     *
     * @param     $msgDataId
     * @param     $userCommentId
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function unMarkelect($msgDataId, $userCommentId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_UNMARKELECT, [
            'msg_data_id'     => $msgDataId,
            'index'           => $index,
            'user_comment_id' => $userCommentId
        ]);
    }

    /**
     * 将评论标记精选
     *
     * @param     $msgDataId
     * @param     $userCommentId
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function markelect($msgDataId, $userCommentId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_MARKELECT, [
            'msg_data_id'     => $msgDataId,
            'index'           => $index,
            'user_comment_id' => $userCommentId
        ]);
    }

    /**
     * 查看指定文章的评论数据
     *
     * @param     $msgDataId
     * @param     $begin
     * @param     $count
     * @param     $type
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function view($msgDataId, $begin, $count, $type, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_LIST, [
            'msg_data_id' => $msgDataId,
            'index'       => $index,
            'begin'       => $begin,
            'count'       => $count,
            'type'        => $type
        ]);
    }

    /**
     * 打开已群发文章评论
     *
     * @param     $msgDataId
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function close($msgDataId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_CLOSE, [
            'msg_data_id' => $msgDataId,
            'index'       => $index
        ]);
    }

    /**
     * 打开已群发文章评论
     *
     * @param     $msgDataId
     * @param int $index
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function open($msgDataId, $index = 0)
    {
        return $this->send(ApiUrl::COMMENT_OPEN, [
            'msg_data_id' => $msgDataId,
            'index'       => $index
        ]);
    }

    /**
     * @param $url
     * @param $data
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    protected function send($url, $data)
    {
        $url = ApiUrl::generateURL($url, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, $data);

        $ex = OfficialAccountError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return $response;
    }

}