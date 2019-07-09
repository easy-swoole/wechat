<?php


namespace EasySwoole\WeChat\MiniProgram;

/**
 * API接口调用地址
 * Class ApiUrl
 * @package EasySwoole\WeChat\MiniProgram
 */
class ApiUrl
{
    /**
     * 授权 - 登录凭证校验
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html
     */
    const AUTH_CODE2SESSION = 'https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code';

    /**
     * 授权 - 支付完成后获取UnionId
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/user-info/auth.getPaidUnionId.html
     */
    const AUTH_GET_PAID_UNIONID = 'https://api.weixin.qq.com/wxa/getpaidunionid?access_token=ACCESS_TOKEN&openid=OPENID';

    /**
     * 授权 - 获取后台接口调用凭据
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/access-token/auth.getAccessToken.html
     */
    const AUTH_GET_ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';

    /**
     * 分析 - 获取用户访问小程序月留存
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getMonthlyRetain.html
     */
    const ANALYSIS_GET_MONTHLY_RETAIN = 'https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyretaininfo?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户访问小程序周留存
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getWeeklyRetain.html
     */
    const ANALYSIS_GET_WEEKLY_RETAIN = 'https://api.weixin.qq.com/datacube/getweanalysisappidweeklyretaininfo?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户访问小程序日存留
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getDailyRetain.html
     */
    const ANALYSIS_GET_DAILY_RETAIN = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailyretaininfo?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户访问小程序数据月趋势
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getMonthlyVisitTrend.html
     */
    const ANALYSIS_GET_MONTHLY_VISIT_TREND = 'https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyvisittrend?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户访问小程序数据周趋势
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getWeeklyVisitTrend.html
     */
    const ANALYSIS_GET_WEEKLY_VISIT_TREND = 'https://api.weixin.qq.com/datacube/getweanalysisappidweeklyvisittrend?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户访问小程序数据日趋势
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getDailyVisitTrend.html
     */
    const ANALYSIS_GET_DAILY_VISIT_TREND = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailyvisittrend?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取小程序新增或活跃用户的画像分布数据
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getUserPortrait.html
     */
    const ANALYSIS_GET_USER_PORTRAIT = 'https://api.weixin.qq.com/datacube/getweanalysisappiduserportrait?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取用户小程序访问分布数据
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getVisitDistribution.html
     */
    const ANALYSIS_GET_VISIT_DISTRIBUTION = 'https://api.weixin.qq.com/datacube/getweanalysisappidvisitdistribution?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取页面访问PV
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getVisitPage.html
     */
    const ANALYSIS_GET_VISIT_PAGE = 'https://api.weixin.qq.com/datacube/getweanalysisappidvisitpage?access_token=ACCESS_TOKEN';

    /**
     * 分析 - 获取小程序访问概况
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getDailySummary.html#method-http
     */
    const ANALYSIS_GET_DAILY_SUMMARY = 'https://api.weixin.qq.com/datacube/getweanalysisappiddailysummarytrend?access_token=ACCESS_TOKEN';

    /**
     * 客服 - 下发正在输入状态
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/customer-message/customerServiceMessage.setTyping.html
     */
    const CUSTOMER_SET_TYPING = 'https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN';

    /**
     * 客服 - 把媒体文件上传到微信服务器
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/customer-message/customerServiceMessage.uploadTempMedia.html
     */
    const CUSTOMER_UPLOAD_TEMP_MEDIA = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE';

    /**
     * 客服 - 获取客服消息内的临时素材
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/customer-message/customerServiceMessage.getTempMedia.html
     */
    const CUSTOMER_GET_TEMP_MEDIA = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID';

    /**
     * 客服 - 发送客服消息给用户
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/customer-message/customerServiceMessage.send.html
     */
    const CUSTOMER_SEND = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 组合模板并添加至帐号下的个人模板库
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.addTemplate.html
     */
    const TEMPLATE_ADD_TEMPLATE = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 删除帐号下的某个模板
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.deleteTemplate.html
     */
    const TEMPLATE_DELETE_TEMPLATE = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 获取模板库某个模板标题下关键词库
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.getTemplateLibraryById.html
     */
    const TEMPLATE_GET_TEMPLATE_LIBRARY_BY_ID = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 获取小程序模板库标题列表
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.getTemplateLibraryList.html
     */
    const TEMPLATE_GET_TEMPLATE_LIBRARY_BY_LIST = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/list?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 获取帐号下已存在的模板列表
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.getTemplateList.html
     */
    const TEMPLATE_GET_TEMPLATE_LIST = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=ACCESS_TOKEN';

    /**
     * 模板消息 - 发送模板消息
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/template-message/templateMessage.send.html
     */
    const TEMPLATE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN';

    /**
     * 统一服务消息 - 发送统一服务消息
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/uniform-message/uniformMessage.send.html
     */
    const UNI_MESSAGE_SEND = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=ACCESS_TOKEN';

    /**
     * 动态消息 - 创建被分享动态消息的 activity_id
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/updatable-message/updatableMessage.createActivityId.html
     */
    const UPDATABLE_MSG_CREATE = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/activityid/create?access_token=ACCESS_TOKEN';

    /**
     * 动态消息 - 修改被分享的动态消息
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/updatable-message/updatableMessage.setUpdatableMsg.html
     */
    const UPDATABLE_MSG_SET = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/updatablemsg/send?access_token=ACCESS_TOKEN';

    /**
     * 二维码 - 永久二维码
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.createQRCode.html
     */
    const WXACODE_CREATE_QRCODE = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN';

    /**
     * 二维码 - 永久小程序码
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.get.html
     */
    const WXACODE_GET = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN';

    /**
     * 二维码 - 临时小程序码
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/qr-code/wxacode.getUnlimited.html
     */
    const WXACODE_GET_UNLIMITED = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN';

    /**
     * 向插件开发者发起使用插件的申请
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.applyPlugin.html
     */
    const APPLY_PLUGIN = 'https://api.weixin.qq.com/wxa/plugin?access_token=TOKEN';

    /**
     * 获取当前所有插件使用方（供插件开发者调用）
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.getPluginDevApplyList.html
     */
     const GET_PLUGIN_DEV_APPLY_LIST = 'https://api.weixin.qq.com/wxa/devplugin?access_token=TOKEN';

    /**
     * 查询已添加的插件
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.getPluginList.html
     */
    const GET_PLUGIN_LiST = 'https://api.weixin.qq.com/wxa/plugin?access_token=TOKEN';

    /**
     * 修改插件使用申请的状态（供插件开发者调用）
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.setDevPluginApplyStatus.html
     */
    const SET_DEV_PLUGIN_APPLY_STATUS = 'https://api.weixin.qq.com/wxa/devplugin?access_token=TOKEN';

    /**
     * 删除已添加的插件
     * @see https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.unbindPlugin.html
     */
    const UNBIND_PLUGIN = 'https://api.weixin.qq.com/wxa/plugin?access_token=TOKEN';


    // TODO 附近的小程序 内容安全 物流助手 生物认证

    /**
     * 生成访问链接
     * @param string $baseUrl 基础链接
     * @param array $data 字符串替换
     * @param array $extraParam 需要并入该链接的额外数据
     * @return string
     */
    public static function generateURL(string $baseUrl, array $data, array $extraParam = []): string
    {
        // 替换链接中大写常量
        foreach ($data as $key => $item) {
            $baseUrl = str_replace($key, $item, $baseUrl);
        }

        // 如果有额外参数 构建查询字符串并拼接
        if (!empty($extraParam)) {
            $extraQueryStr = http_build_query($extraParam);
            $baseUrl = strpos($baseUrl, '?') === false ? "{$baseUrl}?{$extraQueryStr}" : "{$baseUrl}&{$extraQueryStr}";
        }

        return $baseUrl;
    }
}