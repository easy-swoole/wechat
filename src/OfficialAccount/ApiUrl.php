<?php

/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 10:37 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class ApiUrl
{
    /**
     *
     */
    const NET_CHECK = 'https://api.weixin.qq.com/cgi-bin/callback/check?access_token=ACCESS_TOKEN';

    /**
     *
     */
    const IP_LIST = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';

    /*
     * 获取ACCESS_TOKEN
     */
    const ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APP_SECRET';

    /*
     * 获取微信服务器IP地址
     */
    const GET_CALLBACK_IP = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN';

    /*
     * 网络检测
     */
    const CALLBACK_CHECK = 'https://api.weixin.qq.com/cgi-bin/callback/check?access_token=ACCESS_TOKEN';

    /*
     * 获取临时素材
     */
    const MEDIA_GET = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID';

    /*
     * 获取高清语音素材
     */
    const MEDIA_HD_GET = 'https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id=MEDIA_ID';

    /*
     * 上传临时素材
     */
    const MEDIA_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE';

    /*
     * 群发视频信息的视频media_id转换
     */
    const MEDIA_TO_VIDEO = 'https://api.weixin.qq.com/cgi-bin/media/uploadvideo?access_token=ACCESS_TOKEN';

    /*
     * 上传图文消息素材
     */
    const MEDIA_UPLOAD_NEWS = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=ACCESS_TOKEN';

    /**
     * 上传永久素材
     */
    const MATERIAL_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=ACCESS_TOKEN&type=TYPE';

    /**
     * 删除永久素材
     */
    const MATERIAL_DELETE = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=ACCESS_TOKEN';

    /**
     * 获取永久素材
     */
    const MATERIAL_GET = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=ACCESS_TOKEN';

    /**
     * 获取永久素材总数
     */
    const MATERIAL_COUNT = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=ACCESS_TOKEN';

    /**
     * 获取永久素材列表
     */
    const MATERIAL_LIST = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=ACCESS_TOKEN';

    /*
     * 上传图文消息素材
     */
    const MATERIAL_UPLOAD_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=ACCESS_TOKEN';

    /**
     * 修改图文消息素材
     */
    const MATERIAL_UPDATE_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=ACCESS_TOKEN';

    /*
     * 上传图文消息内的图片获取URL
     */
    const MATERIAL_UPLOAD_NEWS_IMG = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN';

    /*
     * 根据标签进行群发图文消息
     */
    const MESSAGE_MASS_SEND_ALL = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=ACCESS_TOKEN';

    /*
     * 根据OpenID列表群发图文消息
     */
    const MESSAGE_MASS_SEND = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=ACCESS_TOKEN';

    /*
     * 删除群发图文消息
     */
    const MESSAGE_MASS_DELETE = 'https://api.weixin.qq.com/cgi-bin/message/mass/delete?access_token=ACCESS_TOKEN';

    /*
     * 预览图文消息
     */
    const MESSAGE_MASS_PREVIEW = 'https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=ACCESS_TOKEN';

    /*
     * 查询群发消息发送状态
     */
    const MESSAGE_MASS_GET = 'https://api.weixin.qq.com/cgi-bin/message/mass/get?access_token=ACCESS_TOKEN';

    /*
     * 获取群发速度
     */
    const MESSAGE_MASS_SPEED_GET = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN';
/*
     * 设置群发速度
     */
    const MESSAGE_MASS_SPEED_SET = 'https://api.weixin.qq.com/cgi-bin/message/mass/speed/set?access_token=ACCESS_TOKEN';

    /*
     * 发送客服消息
     */
    const MESSAGE_CUSTOM_SEND = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN';

    /*
     * 获取用户关注列表
     */
    const USER_GET = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID';

    /*
     * 获取用户基本信息
     */
    const USER_INFO = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=LANG';

    /**
     * 批量获取用户信息
     */
    const USER_INFO_BATCHGET = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=ACCESS_TOKEN';

    /**
     * 设置用户备注
     */
    const USER_UPDATEREMARK = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=ACCESS_TOKEN';

    /**
     * 获取黑名单列表
     */
    const GET_BLACKLIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=ACCESS_TOKEN';

    /**
     * 添加黑名单
     */
    const BATCH_BLACKLIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=ACCESS_TOKEN';

    /**
     * 移出黑名单
     */
    const BATCH_UNBLACKLIST = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=ACCESS_TOKEN';

    /**
     * 迁移Openid
     * by http://kf.qq.com/faq/170221aUnmmU170221eUZJNf.html
     */
    const CHANGE_OPENID = 'http://api.weixin.qq.com/cgi-bin/changeopenid?access_token=ACCESS_TOKEN';

    /**
     * 获取标签列表
     */
    const TAG_LIST = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token=ACCESS_TOKEN';

    /**
     * 创建标签
     */
    const TAG_CREATE = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=ACCESS_TOKEN';

    /**
     * 编辑标签
     */
    const TAG_UPDATE = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token=ACCESS_TOKEN';

    /**
     * 删除标签
     */
    const TAG_DELETE = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=ACCESS_TOKEN';

    /**
     * 获取用户标签列表
     */
    const GET_USER_TAG_LIST = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token=ACCESS_TOKEN';

    /**
     * 使用标签获取用户列表
     */
    const GET_USER_LIST_OF_TAG = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=ACCESS_TOKEN';

    /**
     * 批量设置用户标签
     */
    const BATCH_TAGGING = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=ACCESS_TOKEN';

    /**
     * 批量移除用户标签
     */
    const BATCH_UNTAGGING = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging?access_token=ACCESS_TOKEN';

    /*
     * 查询分组
     */
    const GROUPS_GET = 'https://api.weixin.qq.com/cgi-bin/groups/get?access_token=ACCESS_TOKEN';

    /*
     * 创建分组
     */
    const GROUPS_CREATE = 'https://api.weixin.qq.com/cgi-bin/groups/create?access_token=ACCESS_TOKEN';

    /*
     * 修改分组名
     */
    const GROUPS_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/update?access_token=ACCESS_TOKEN';

    /*
     * 移动用户分组
     */
    const GROUPS_MEMBERS_UPDATE = 'https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=ACCESS_TOKEN';

    /*
     * 查询用户分组ID
     */
    const GROUPS_GET_ID = 'https://api.weixin.qq.com/cgi-bin/groups/getid?access_token=ACCESS_TOKEN';

    /*
     * 自定义菜单创建
     */
    const MENU_CREATE = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN';

    /*
     * 自定义菜单查询
     */
    const MENU_GET = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN';

    /*
     * 自定义菜单删除
     */
    const MENU_DELETE = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN';

    /*
     * 创建个性化菜单
     */
    const MENU_ADD_CONDITIONAL = 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=ACCESS_TOKEN';

    /**
     * 测试个性化菜单
     */
    const MENU_MATCH_CONDITIONAL = 'https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token=ACCESS_TOKEN';

    /**
     * 删除个性化菜单
     */
    const MENU_DELETE_CONDITIONAL = 'https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=ACCESS_TOKEN';

    /*
     * 获取自定义菜单配置
     */
    const GET_CURRENT_SELFMENU_INFO = 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=ACCESS_TOKEN';

    /**
     * 发送模板消息
     */
    const TEMPLATE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN';

    /**
     * 删除模板消息
     */
    const TEMPLATE_DELETE = 'https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=ACCESS_TOKEN';

    /**
     * 获取模板消息列表
     */
    const TEMPLATE_GET_ALL = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN';

    /**
     * 添加模板消息
     */
    const TEMPLATE_ADD = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN';

    /**
     * 设置所属行业
     */
    const TEMPLATE_SET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=ACCESS_TOKEN';

    /**
     * 获取行业信息
     */
    const TEMPLATE_GET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=ACCESS_TOKEN';

    /**
     * 发送一次性订阅消息
     */
    const TEMPLATE_SEND_SUBSCRIBE = 'https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=ACCESS_TOKEN';

    /*
     * 客服消息-添加客服账号
     */
    const CUSTOM_SERVICE_KF_ACCOUNT_ADD = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=ACCESS_TOKEN';

    /*
     * 客服消息-修改客服账号
     */
    const CUSTOM_SERVICE_KF_ACCOUNT_UPDATE = 'https://api.weixin.qq.com/customservice/kfaccount/update?access_token=ACCESS_TOKEN';

    /*
     * 客服消息-删除客服账号
     */
    const CUSTOM_SERVICE_KF_ACCOUNT_DELETE = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=ACCESS_TOKEN';

    /*
     * 客服消息-设置客服账号的头像
     */
    const CUSTOM_SERVICE_KF_ACCOUNT_UPLOAD_HEAD_IMG = 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=ACCESS_TOKEN&kf_account=KF_ACCOUNT';

    /*
     * 客服消息-获取所有客服账号
     */
    const CUSTOM_SERVICE_GET_KF_LIST = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=ACCESS_TOKEN';

    /*
     * 客服消息-客服输入状态
     */
    const MESSAGE_CUSTOM_TYPING = 'https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN';

    /*
     * 将一条长链接转成短链接
     */
    const SHORT_URL = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token=ACCESS_TOKEN';

    /*
     * 创建二维码ticket
     */
    const QRCODE_CREATE = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN';

    /*
     * 换取二维码
     */
    const SHOW_QRCODE = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET';

    /*
     * 设备授权-获取deviceid和二维码
     */
    const DEVICE_GET_QRCODE = 'https://api.weixin.qq.com/device/getqrcode?access_token=ACCESS_TOKEN';

    /* 
     * 设备授权-利用deviceid更新设备属性
     */
    const DEVICE_AUTHORIZE_DEVICE = 'https://api.weixin.qq.com/device/authorize_device?access_token=ACCESS_TOKEN';

    /*
     * 验证设备二维码
     * */
    const DEVICE_VERIFY_QRCODE = 'https://api.weixin.qq.com/device/verify_qrcode?access_token=ACCESS_TOKEN';

    /*
     * 查询设备状态
     * */
    const DEVICE_GET_STAT = 'https://api.weixin.qq.com/device/get_stat?access_token=ACCESS_TOKEN&device_id=DEVICE_ID';

    /*
     * 设备绑定-绑定成功通知
     * */
    const DEVICE_BIND = 'https://api.weixin.qq.com/device/bind?access_token=ACCESS_TOKEN';

    /*
     * 设备绑定-强制绑定用户和设备
     * */
    const DEVICE_COMPEL_BIND = 'https://api.weixin.qq.com/device/compel_bind?access_token=ACCESS_TOKEN';

    /*
     * 设备解绑-解绑成功通知
     * */
    const DEVICE_UNBIND = 'https://api.weixin.qq.com/device/unbind?access_token=ACCESS_TOKEN';


    /*
     * 设备解绑-强制解绑用户和设备
     * */
    const DEVICE_COMPEL_UNBIND = 'https://api.weixin.qq.com/device/compel_unbind?access_token=ACCESS_TOKEN';

    /*
     * 查询设备绑定的用户
     * */
    const DEVICE_GET_OPENID = 'https://api.weixin.qq.com/device/get_openid?access_token=ACCESS_TOKEN&device_type=DEVICE_TYPE&device_id=DEVICE_TYPE';

    /*
     * 查询用户绑定的设备
     * */
    const DEVICE_GET_BIND_DEVICE = 'https://api.weixin.qq.com/device/get_bind_device?access_token=ACCESS_TOKEN&openid=OPENID';

    /*
     * 推送消息-发送设备消息
     * */
    const DEVICE_TRANS_MSG = 'https://api.weixin.qq.com/device/transmsg?access_token=ACCESS_TOKEN';

    /*
     * 创建卡券
     * */
    const CARD_CREATE = 'https://api.weixin.qq.com/card/create?access_token=ACCESS_TOKEN';

    /*
     * 创建卡券二维码获取ticket
     * */
    const CARD_QRCODE_CREATE = 'https://api.weixin.qq.com/card/qrcode/create?access_token=ACCESS_TOKEN';

    /*
     * 设置卡券测试白名单
     * */
    const CARD_TEST_WHITELIST = 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=ACCESS_TOKEN';

    /*
     * 核销卡券
     * */
    const CARD_CONSUME = 'https://api.weixin.qq.com/card/code/consume?access_token=ACCESS_TOKEN';

    /*
     * 打开已群发文章评论
     * */
    const COMMENT_OPEN = 'https://api.weixin.qq.com/cgi-bin/comment/open?access_token=ACCESS_TOKEN';

    /*
     * 关闭已群发文章评论
     * */
    const COMMENT_CLOSE = 'https://api.weixin.qq.com/cgi-bin/comment/close?access_token=ACCESS_TOKEN';

    /*
     * 查看文章评论数据
     * */
    const COMMENT_LIST = 'https://api.weixin.qq.com/cgi-bin/comment/list?access_token=ACCESS_TOKEN';

    /*
     * 精选评论
     * */
    const COMMENT_MARKELECT = 'https://api.weixin.qq.com/cgi-bin/comment/markelect?access_token=ACCESS_TOKEN';

    /*
    * 取消精选评论
    * */
    const COMMENT_UNMARKELECT = 'https://api.weixin.qq.com/cgi-bin/comment/unmarkelect?access_token=ACCESS_TOKEN';

    /*
    * 删除评论
    * */
    const COMMENT_DELETE = 'https://api.weixin.qq.com/cgi-bin/comment/delete?access_token=ACCESS_TOKEN';

    /*
    * 回复评论
    * */
    const COMMENT_REPLY_ADD = 'https://api.weixin.qq.com/cgi-bin/comment/reply/add?access_token=ACCESS_TOKEN';

    /*
     * 删除回复评论
     * */
    const COMMENT_REPLY_DELETE = 'https://api.weixin.qq.com/cgi-bin/comment/reply/delete?access_token=ACCESS_TOKEN';

    /**
     * 网页授权跳转链接
     */
    const JSAPI_AUTHORIZE = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

    /**
     * 网页授权CODE换取ACCESS_TOKEN
     */
    const JSAPI_CODE_TO_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

    /**
     * 网页授权令牌刷新
     */
    const JSAPI_REFRESH_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN';

    /**
     * 网页授权获取用户信息
     */
    const JSAPI_SNS_USERINFO = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN';

    /**
     * 网页授权检验授权凭证
     */
    const JSAPI_SNS_AUTH_CHECK = 'https://api.weixin.qq.com/sns/auth?access_token=ACCESS_TOKEN&openid=OPENID';

    /**
     * 获取JSSDK授权票据
     */
    const JSAPI_GET_TICKET = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi';

    /**
     * 获取用户增减数据
     */
    const GET_USER_SUMMARY = 'https://api.weixin.qq.com/datacube/getusersummary?access_token=ACCESS_TOKEN';

    /**
     * 获取累计用户数据
     */
    const GET_USER_CUMULATE = 'https://api.weixin.qq.com/datacube/getusercumulate?access_token=ACCESS_TOKEN';

    /**
     * 获取图文群发每日数据
     */
    const GET_ARTICLE_SUMMARY = 'https://api.weixin.qq.com/datacube/getarticlesummary?access_token=ACCESS_TOKEN';

    /**
     * 获取图文群发总数据
     */
    const GET_ARTICLE_TOTAL = 'https://api.weixin.qq.com/datacube/getarticletotal?access_token=ACCESS_TOKEN';

    /**
     * 获取图文统计数据
     */
    const GET_USER_READ = 'https://api.weixin.qq.com/datacube/getuserread?access_token=ACCESS_TOKEN';

    /**
     * 获取图文统计分时数据
     */
    const GET_USER_READ_HOUR = 'https://api.weixin.qq.com/datacube/getuserreadhour?access_token=ACCESS_TOKEN';

    /**
     * 获取图文分享转发数据
     */
    const GET_USER_SHARE = 'https://api.weixin.qq.com/datacube/getusershare?access_token=ACCESS_TOKEN';

    /**
     * 获取图文分享转发分时数据
     */
    const GET_USER_SHARE_HOUR = 'https://api.weixin.qq.com/datacube/getusersharehour?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送概况数据
     */
    const GET_UP_STREAM_MSG = 'https://api.weixin.qq.com/datacube/getupstreammsg?access_token=ACCESS_TOKEN';

    /**
     * 获取消息分送分时数据
     */
    const GET_UP_STREAM_MSG_HOUR = 'https://api.weixin.qq.com/datacube/getupstreammsghour?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送周数据
     */
    const GET_UP_STREAM_MSG_WEEK = 'https://api.weixin.qq.com/datacube/getupstreammsgweek?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送月数据
     */
    const GET_UP_STREAM_MSG_MONTH = 'https://api.weixin.qq.com/datacube/getupstreammsgmonth?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送分布数据
     */
    const GET_UP_STREAM_MSG_DIST = 'https://api.weixin.qq.com/datacube/getupstreammsgdist?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送分布周数据
     */
    const GET_UP_STREAM_MSG_DIST_WEEK = 'https://api.weixin.qq.com/datacube/getupstreammsgdistweek?access_token=ACCESS_TOKEN';

    /**
     * 获取消息发送分布月数据
     */
    const GET_UP_STREAM_MSG_DIST_MONTH = 'https://api.weixin.qq.com/datacube/getupstreammsgdistmonth?access_token=ACCESS_TOKEN';

    /**
     * 获取公众号分广告位数据
     */
    const PUBLISHER_ADPOS_GENERAL = 'https://api.weixin.qq.com/publisher/stat?action=publisher_adpos_general&access_token=ACCESS_TOKEN';

    /**
     * 获取公众号返佣商品数据
     */
    const PUBLISHER_CPS_GENERAL = 'https://api.weixin.qq.com/publisher/stat?action=publisher_cps_general&access_token=ACCESS_TOKEN';

    /**
     * 获取公众号结算收入数据及结算主体信息
     */
    const PUBLISHER_SETTLEMENT = 'https://api.weixin.qq.com/publisher/stat?action=publisher_settlement&access_token=ACCESS_TOKEN';

    /**
     * 获取接口分析数据
     */
    const GET_INTERFACE_SUMMARY = 'https://api.weixin.qq.com/datacube/getinterfacesummary?access_token=ACCESS_TOKEN';

    /**
     * 获取接口分析分时数据
     */
    const GET_INTERFACE_SUMMARY_HOUR = 'https://api.weixin.qq.com/datacube/getinterfacesummaryhour?access_token=ACCESS_TOKEN';

    /**
     * @param string $baseUrl
     * @param array  $data
     *
     * @return string
     */
    public static function generateURL(string $baseUrl, array $data) : string
    {
        foreach ($data as $key => $item) {
            $baseUrl = str_replace($key, $item, $baseUrl);
        }

        return $baseUrl;
    }
}