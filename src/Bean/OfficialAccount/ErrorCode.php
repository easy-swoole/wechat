<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 17:20
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\WeChat\AbstractInterface\AbstractErrorCodeEnum;

class ErrorCode extends AbstractErrorCodeEnum
{
    /*
     * map to https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433747234
     */

    /**
     * 正常
     */
    const OK = 0;

    /**
     * 系统繁忙
     */
    const SYS_BUSY = -1;

    /**
     *  access_token 无效 或者 AppSecret 错误
     */
    const INVALID_ACCESS_TOKEN_OR_APP_SECRET = 40001;

    /**
     * 不合法的凭证类型
     */
    const INVALID_DOCUMENT_TYPE = 40002;

    /**
     * 不合法的 openid
     */
    const INVALID_OPENID = 40003;

    /**
     * 不合法的媒体文件类型
     */
    const INVALID_MEDIA_FILE_TYPE = 40004;

    /**
     * 不合法的文件类型
     */
    const INVALID_FILE_TYPE = 40005;

    /**
     * 不合法的文件大小
     */
    const INVALID_FILE_SIZE = 40006;

    /**
     * 不合法的媒体文件ID
     */
    const INVALID_MEDIA_FILE_ID = 40007;

    /**
     * 不合法的消息类型
     */
    const INVALID_MESSAGE_TYPE = 40008;

    /**
     * 不合法的图片文件大小
     */
    const INVALID_IMAGE_FILE_SIZE = 40009;

    /**
     * 不合法的语音文件大小
     */
    const INVALID_AUDIO_FILE_SIZE = 40010;

    /**
     * 不合法的视频文件大小
     */
    const INVALID_VIDEO_FILE_SIZE = 40011;

    /**
     * 不合法的缩略图文件大小
     */
    const INVALID_THUMBNAIL_FILE_SIZE = 40012;

    /**
     * 不合法的APP_ID
     */
    const INVALID_APP_ID = 40013;

    /**
     * 不合法的 access_token
     */
    const INVALID_ACCESS_TOKEN = 40014;

    /**
     * 不合法的 菜单类型
     */
    const INVALID_MENU_TYPE = 40015;

    /**
     * 不合法的 菜单按钮数量
     */
    const INVALID_MENU_BUTTON_NUMBER = 40016;

    /**
     * 不合法的 菜单按钮数量
     */
//    const INVALID_MENU_BUTTON_NUMBER = 40017;

    /**
     * 不合法的 按钮name长度
     */
    const INVALID_BUTTON_NAME_LENGTH = 40018;

    /**
     * 不合法的 按钮key长度
     */
    const INVALID_BUTTON_KEY_LENGTH = 40019;

    /**
     * 不合法的 按钮url长度
     */
    const INVALID_BUTTON_URI_LENGTH = 40020;

    /**
     * 不合法的 菜单版本号
     */
    const INVALID_MENU_VERSION = 40021;

    /**
     * 不合法的 子菜单级数
     */
    const INVALID_SUBMENU_LEVEL = 40022;

    /**
     * 不合法的 子菜单按钮数量
     */
    const INVALID_SUBMENU_BUTTON_NUMBER = 40023;

    /**
     * 不合法的 子菜单按钮类型
     */
    const INVALID_SUBMENU_BUTTON_TYPE = 40024;

    /**
     * 不合法的 子菜单按钮name长度
     */
    const INVALID_SUBMENU_BUTTON_NAME_LENGTH = 40025;

    /**
     * 不合法的 子菜单按钮key长度
     */
    const INVALID_SUBMENU_BUTTON_KEY_LENGTH = 40026;

    /**
     * 不合法的 子菜单按钮url长度
     */
    const INVALID_SUBMENU_BUTTON_URI_LENGTH = 40027;

    /**
     * 不合法的 自定义菜单 使用者
     */
    const INVALID_CUSTOM_MENU_USER = 40028;

    /**
     * 不合法的 oauth_code
     */
    const INVALID_OAUTH_CODE = 40029;

    /**
     * 不合法的 refresh_token
     */
    const INVALID_REFRESH_TOKEN = 40030;

    /**
     * 不合法的 openid 列表
     */
    const INVALID_OPENID_LIST = 40031;

    /**
     * 不合法的 openid 列表长度
     */
    const INVALID_OPENID_LIST_LENGTH = 40032;

    /**
     * 不合法的 请求字符
     */
    const INVALID_REQUEST_CHARACTER = 40033;

    /**
     * 不合法的 参数
     */
    const INVALID_PARAMETERS = 40035;

    /**
     * 不合法的 请求格式
     */
    const INVALID_REQUEST_FORMAT = 40038;

    /**
     * 不合法的 url 长度
     */
    const INVALID_URI_LENGTH = 40039;

    /**
     * 不合法的 分组ID
     */
    const INVALID_GROUP_ID = 40050;

    /**
     * 不合法的 分组名称
     */
    const INVALID_GROUP_NAME = 40051;

    /**
     * 不合法的 图文ID
     */
    const INVALID_ARTICLE_IDX = 40060;

    /**
     * 不合法的 分组名称
     */
//    const INVALID_GROUP_NAME = 40117;

    /**
     * 不合法的 媒体ID 大小
     */
    const INVALID_MEDIA_ID_SIZE = 40118;

    /**
     * 按钮类型错误
     */
    const BUTTON_TYPE_ERROR = 40019;

    /**
     * 按钮类型错误
     */
//    const BUTTON_TYPE_ERROR = 40020;

    /**
     * 不合法的 媒体ID类型
     */
    const INVALID_MEDIA_ID_TYPE = 40121;

    /**
     * 微信号不合法
     */
    const INVALID_WECHAT_ACCOUNT = 40132;

    /**
     * 不支持的图片格式
     */
    const UNSUPPORTED_IMAGE_FORMAT = 40137;

    /**
     * 请勿添加其他公众号的主页链接
     */
    const INVALID_ADD_LINK = 40155;

    /**
     * 缺少 access_token 参数
     */
    const MISSING_ACCESS_TOKEN_PARAMETERS = 41001;

    /**
     * 缺少 appid 参数
     */
    const MISSING_APP_ID_PARAMETERS = 41002;

    /**
     * 缺少 refresh_token 参数
     */
    const MISSING_REFRESH_TOKEN_PARAMETERS = 41003;

    /**
     * 缺少 secret 参数
     */
    const MISSING_SECRET_PARAMETERS = 41004;

    /**
     * 缺少 secret 参数
     */
    const MISSING_MULTIMEDIA_FILE_PARAMETERS = 41005;

    /**
     * 缺少 media_id 参数
     */
    const MISSING_MEDIA_ID_PARAMETERS = 41006;

    /**
     * 缺少 子菜单数据
     */
    const MISSING_SUBMENU_DATA = 41007;

    /**
     * 缺少 oauth code
     */
    const MISSING_OAUTH_CODE = 41008;

    /**
     * 缺少 openid
     */
    const MISSING_OPENID = 41009;

    /**
     * access_token 过期
     */
    const ACCESS_TOKEN_EXPIRED = 42001;

    /**
     * refresh_token 过期
     */
    const REFRESH_TOKEN_EXPIRED = 42002;

    /**
     * oauth_code 过期
     */
    const OAUTH_CODE_EXPIRED = 42003;

    /**
     * 用户修改微信密码， access_token 和 refresh_token 失效，需要重新授权
     */
    const INVALID_REFRESH_TOKEN_AND_OAUTH_CODE = 42007;

    /**
     * 必须 GET 请求
     */
    const MUST_GET_REQUEST = 43001;

    /**
     * 必须 POST 请求
     */
    const MUST_POST_REQUEST = 43002;

    /**
     * 必须 HTTPS 请求
     */
    const MUST_HTTPS_REQUEST = 43003;

    /**
     * 必须 接收者 关注
     */
    const MUST_RECIPIENT_SUBSCRIPTION = 43004;

    /**
     * 必须 好友关系
     */
    const MUST_FRIEND_RELATIONSHIP = 43005;

    /**
     * 必须 接收者从黑名单移除
     */
    const MUST_RECIPIENT_REMOVE_BLACKLIST = 43019;

    /**
     * 多媒体文件 为空
     */
    const MULTIMEDIA_FILE_EMPTY = 44001;

    /**
     * post 数据包 为空
     */
    const POST_DATA_PACK_EMPTY = 44002;

    /**
     * 图文消息内容 为空
     */
    const ARTICLE_CONTENT_EMPTY = 44003;

    /**
     * 文本消息内容 为空
     */
    const TEXT_CONTENT_EMPTY = 44004;

    /**
     * 多媒体文件大小 超限
     */
    const MULTIMEDIA_FILE_SIZE_EXCEEDS_LIMIT = 45001;

    /**
     * 消息内容 超限
     */
    const MESSAGE_CONTENT_LENGTH_EXCEEDS_LIMIT = 45002;

    /**
     * 标题字段 超限
     */
    const TITLE_FIELD_LENGTH_EXCEEDS_LIMIT = 45003;

    /**
     * 描述字段 超限
     */
    const DESCRIPTION_FIELD_LENGTH_EXCEEDS_LIMIT = 45004;

    /**
     * 链接字段 超限
     */
    const LINK_FIELD_LENGTH_EXCEEDS_LIMIT = 45005;

    /**
     * 图片链接字段 超限
     */
    const IMAGE_LINK_FIELD_LENGTH_EXCEEDS_LIMIT = 45006;

    /**
     * 语音播放时间 超限
     */
    const AUDIO_DURATION_EXCEEDS_LIMIT = 45007;

    /**
     * 图文消息 超限
     */
    const ARTICLE_LENGTH_EXCEEDS_LIMIT = 45008;

    /**
     * Api 接口调用次数 超限
     */
    const API_CALLS_NUMBER_EXCEEDS_LIMIT = 45009;

    /**
     * 创建菜单个数 超限
     */
    const CREATE_MENU_NUMBER_EXCEEDS_LIMIT = 45010;

    /**
     * Api 调用频繁
     */
    const API_CALLS_FREQUENT = 45011;

    /**
     * 回复时间 超限
     */
    const REPLY_TIMEOUT = 45015;

    /**
     * 系统分组 不允许修改
     */
    const NOT_ALLOWED_SYSTEM_GROUP = 45016;

    /**
     * 分组名字 超限
     */
    const GROUP_NAME_LENGTH_EXCEEDS_LIMIT = 45017;

    /**
     * 分组数量 超限
     */
    const GROUP_NUMBER_EXCEEDS_LIMIT = 45018;

    /**
     * 客服接口下行条数 超限
     */
    const CUSTOMER_SERVICE_DOWN_NUMBER_EXCEEDS_LIMIT = 45047;

    /**
     * 媒体数据 不存在
     */
    const MEDIA_DATA_NOT_EXIST = 46001;

    /**
     * 菜单版本 不存在
     */
    const MENU_VERSION_NOT_EXIST = 46002;

    /**
     * 菜单数据 不存在
     */
    const MENU_DATA_NOT_EXIST = 46003;

    /**
     * 用户 不存在
     */
    const USER_NOT_EXIST = 46004;

    /**
     * Json 或 xml 解析失败
     */
    const JSON_OR_XML_PARSING_FAILURE = 47001;

    /**
     * api 功能未授权，请确认公众号已获得该接口，可以在公众平台官网 - 开发者中心页中查看接口权限
     */
    const API_NOT_AUTHORIZED = 48001;

    /**
     * 粉丝拒收消息
     */
    const USER_REJECTION_MESSAGE = 48002;

    /**
     * api 接口被封禁，请登录 mp.weixin.qq.com 查看详情
     */
    const API_BANNED = 48004;

    /**
     * api 清零次数达到上限
     */
    const API_RESET_UPPER_LIMIT = 48006;

    /**
     * 没有发送此 消息类型 的权限
     */
    const NOT_PERMISSION_SEND_MESSAGE_TYPE = 48008;

    /**
     * 用户未授权
     */
    const USER_NOT_AUTHORIZED = 50001;

    /**
     * 用户受限
     */
    const USER_RESTRICTED = 50002;

    /**
     * 用户未关注
     */
    const USER_UNSUBSCRIPTION = 50005;

    /**
     * 参数错误
     */
    const PARAMETER_ERROR = 61451;

    /**
     * 无效客服账户
     */
    const INVALID_CUSTOMER_SERVICE_ACCOUNT = 61452;

    /**
     * 客服账号已存在
     */
    const CUSTOMER_SERVICE_ACCOUNT_EXISTS = 61453;

    /**
     * 客服账号名长度超限
     */
    const CUSTOMER_SERVICE_ACCOUNT_LENGTH_EXCEEDS_LIMIT = 61454;

    /**
     * 客服帐号名包含非法字符
     */
    const ILLEGAL_CHARACTER_IN_CUSTOMER_SERVICE_ACCOUNT = 61455;

    /**
     * 客服账号数量超限
     */
    const CUSTOMER_SERVICE_ACCOUNT_NUMBER_EXCEEDS_LIMIT = 61456;

    /**
     * 无效的头像文件类型
     */
    const INVALID_AVATAR_FILE_TYPE = 61457;

    /**
     * 日期格式错误
     */
    const DATE_FORMAT_ERROR = 61500;

    /**
     * 菜单ID 不存在
     */
    const MENU_ID_NOT_EXIST = 65301;

    /**
     * 找不到用户
     */
    const USER_NOT_FOUND = 65302;

    /**
     * 默认菜单为空
     */
    const DEFAULT_MENU_EMPTY = 65303;

    /**
     * 匹配规则为空
     */
    const MATCH_RULE_EMPTY = 65304;

    /**
     * 个性化菜单数量 超限
     */
    const PERSONALIZED_MENU_NUMBER_EXCEEDS_LIMIT = 65305;

    /**
     * 不支持个性化菜单的账户
     */
    const NOT_SUPPORTED_PERSONALIZED_MENU_ACCOUNT = 65306;

    /**
     * 个性化菜单为空
     */
    const PERSONALIZED_MENU_EMPTY = 65307;

    /**
     * button 响应类型 为空
     */
    const BUTTON_RESPONSE_TYPE_EMPTY = 65308;

    /**
     * 个性化菜单开关处于关闭状态
     */
    const PERSONALIZED_MENU_IS_OFF = 65309;

    /**
     * 国家信息不能为空
     */
    const COUNTRY_IS_NOT_EMPTY = 65310;

    /**
     * 省份信息不能为空
     */
    const PROVINCE_IS_NOT_EMPTY = 65311;

    /**
     * 不合法的 国家
     */
    const INVALID_COUNTRY = 65312;

    /**
     * 不合法的 省份
     */
    const INVALID_PROVINCE = 65313;

    /**
     * 不合法的 城市
     */
    const INVALID_CITY = 65314;

    /**
     * 菜单跳转域名数量 超限
     */
    const MENU_DOMAIN_NAME_NUMBER_EXCEEDS_LIMIT = 65316;

    /**
     * 不合法的 URL
     */
    const INVALID_URI = 65317;

    /**
     * 无效的 POST 请求参数
     */
    const INVALID_POST_PARAMETERS = 9001001;

    /**
     * 远程服务器不可用
     */
    const REMOTE_SERVICE_NOT_AVAILABLE = 9001002;

    /**
     * 不合法的 Ticket
     */
    const INVALID_TICKET = 9001003;

    /**
     * 获取附近用户 失败
     */
    const GET_NEARBY_USERS_FAILURE = 9001004;

    /**
     * 获取商户信息 失败
     */
    const GET_MERCHANT_INFO_FAILURE = 9001005;

    /**
     * 获取 openid 失败
     */
    const GET_OPENID_FAILURE = 9001006;

    /**
     * 上传文件 不完整
     */
    const UPLOAD_FILE_INCOMPLETE = 9001007;

    /**
     * 上传 素材文件 类型 不合法
     */
    const INVALID_UPLOAD_MATERIAL_FILE_TYPE = 9001008;

    /**
     * 上传 素材文件 尺寸 不合法
     */
    const INVALID_UPLOAD_MATERIAL_FILE_SIZE = 9001009;

    /**
     * 上传失败
     */
    const UPLOAD_FAILURE = 9001010;

    /**
     * 账号 不合法
     */
    const INVALID_ACCOUNT = 9001020;

    /**
     * 激活率过低
     */
    const FEW_ACTIVATION_RATE = 9001021;

    /**
     * 设备审核数量 不合法
     */
    const INVALID_DEVICE_REVIEW_NUMBER = 9001022;

    /**
     * 此设备ID 已存在
     */
    const DEVICE_ID_EXISTED = 9001023;

    /**
     * 查询设备列表 超限
     */
    const QUERY_DEVICE_ID_NUMBER_EXCEED_LIMIT = 9001024;

    /**
     * 设备ID 不合法
     */
    const INVALID_DEVICE_ID = 9001025;

    /*
     * 页面ID 不合法
     */
    const INVALID_PAGE_ID = 9001026;

    /**
     * 页面参数不合法
     */
    const INVALID_PAGE_PARAMETER = 9001027;

    /**
     * 删除页面ID数量 超限
     */
    const DELETE_PAGE_ID_NUMBER_EXCEED_LIMIT = 9001028;

    /**
     * 页面未被设备释放
     */
    const PAGE_NOT_RELEASED_BY_DEVICE = 9001029;

    /**
     * 查询页面ID数量 超限
     */
    const QUERY_PAGE_ID_NUMBER_EXCEED_LIMIT = 9001030;

    /**
     * 时间区间 不合法
     */
    const INVALID_TIME_INTERVAL = 9001031;

    /**
     * 页面绑定设备参数 错误
     */
    const PAGE_BINDING_DEVICE_PARAMETER_ERROR = 9001032;

    /**
     * 门店ID 不合法
     */
    const INVALID_STORE_ID = 9001033;

    /**
     * 设备备注信息过长
     */
    const DEVICE_REMARK_LENGTH_EXCEED_LIMIT = 9001034;

    /**
     * 设备申请参数 不合法
     */
    const INVALID_DEVICE_REVIEW_PARAMETER = 9001035;

    /**
     * 查询起始值(begin) 不合法
     */
    const INVALID_QUERY_BEGIN_VALUE = 9001036;

    /**
     * redirect_uri 域名与后台配置不一致
     * 回调授权域名不匹配
     */
    const REDIRECT_URI_ERROR = 10003;

    /**
     * 公众号被封禁
     */
    const OFFICIAL_ACCOUNT_BANNED = 10004;

    /**
     * 公众号未拥有 scope(应用授权作用域) 权限
     */
    const OFFICIAL_ACCOUNT_NOT_SCOPE_PERMISSION = 10005;

    /**
     * 必须关注测试账号
     */
    const MUST_SUBSCRIBE_TEST_ACCOUNT = 10006;

    /**
     * 操作频繁
     */
    const FREQUENT_OPERATION = 10009;

    /**
     * scope(应用授权作用域) 不能为空
     */
    const SCOPE_NOT_EMPTY = 10010;

    /**
     * 回调授权url 不能为空
     */
    const REDIRECT_URI_NOT_EMPTY = 10011;

    /**
     * appid 不能为空
     */
    const APP_ID_NOT_EMPTY = 10012;

    /**
     * state(重定自定义参数) 不能为空
     */
    const STATE_NOT_EMPTY = 10013;

    /**
     * 公众号未开放第三方平台授权
     */
    const OFFICIAL_ACCOUNT_NOT_OPEN_PERMISSION = 10015;

    /**
     * 不支持开放平台 Appid 请使用公众号 Appid
     */
    const APP_ID_ERROR = 10016;
}