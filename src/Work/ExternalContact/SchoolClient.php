<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class SchoolClient extends BaseClient
{
    /**
     * 创建部门
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92340
     *
     * @param string $name
     * @param int $parentId
     * @param int $type
     * @param int $standardGrade
     * @param int $registerYear
     * @param int $order
     * @param array $departmentAdmins [['userid':'139','type':1],['userid':'1399','type':2]]
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createDepartment(string $name, int $parentId, int $type, int $standardGrade, int $registerYear, int $order, array $departmentAdmins)
    {
        $params = [
            'name' => $name,
            'parentid' => $parentId,
            'type' => $type,
            'standard_grade' => $standardGrade,
            'register_year' => $registerYear,
            'order' => $order,
            'department_admins' => $departmentAdmins
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/department/create',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 更新部门
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92341
     *
     * @param int $id
     * @param string $name
     * @param int $parentId
     * @param int $type
     * @param int $standardGrade
     * @param int $registerYear
     * @param int $order
     * @param array $departmentAdmins [['op':0,'userid':'139','type':1],['op':1,'userid':'1399','type':2]] OP=0表示新增或更新，OP=1表示删除管理员
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateDepartment(int $id, string $name, int $parentId, int $type, int $standardGrade, int $registerYear, int $order, array $departmentAdmins)
    {
        $params = [
            'id' => $id,
            'name' => $name,
            'parentid' => $parentId,
            'type' => $type,
            'standard_grade' => $standardGrade,
            'register_year' => $registerYear,
            'order' => $order,
            'department_admins' => $departmentAdmins
        ];
        $params = $this->filterNullValue($params);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/department/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除部门
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92342
     *
     * @param int $id
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteDepartment(int $id)
    {
        $query = [
            'id' => $id,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/department/delete',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取部门列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92343
     *
     * @param int $id
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getDepartments(int $id)
    {
        if ($id > 0) {
            $params = [
                'id' => $id
            ];
        } else {
            $params = [];
        }

        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/department/list',
                $params
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 创建学生
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92325
     *
     * @param string $userId
     * @param string $name
     * @param array $department
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createStudent(string $userId, string $name, array $department)
    {
        $params = [
            'student_userid' => $userId,
            'name' => $name,
            'department' => $department
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/ccgi-bin/school/user/create_student',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 删除学生
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92326
     *
     * @param string $userId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteStudent(string $userId)
    {
        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/user/delete_student',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 更新学生
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92327
     *
     * @param string $userId
     * @param string $name
     * @param string $newUserId
     * @param array $department
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateStudent(string $userId, string $name, string $newUserId, array $department)
    {
        $params = [
            'student_userid' => $userId
        ];
        if (!empty($name)) {
            $params['name'] = $name;
        }
        if (!empty($newUserId)) {
            $params['new_student_userid'] = $newUserId;
        }
        if (!empty($department)) {
            $params['department'] = $department;
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/update_student',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 批量创建学生，学生最多100个
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92328
     *
     * @param array $students 学生格式：[[student_userid:'','name':'','department':[1,2]],['student_userid':'','name':'','department':[1,2]]]
     *
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchCreateStudents(array $students)
    {
        $params = [
            'students' => $students
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_create_student',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量删除学生，每次最多100个学生
     *
     * @param array $useridList 学生USERID，格式：['zhangsan','lisi']
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchDeleteStudents(array $useridList)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'useridlist' => $useridList
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_delete_student',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量更新学生，每次最多100个
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92330
     *
     * @param array $students 格式：[['student_userid':'lisi','new_student_userid':'lisi2','name':'','department':[1,2]],.....]
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchUpdateStudents(array $students)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'students' => $students
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_update_student',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 创建家长
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92331
     *
     * @param string $userId
     * @param string $mobile
     * @param bool $toInvite
     * @param array $children
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createParent(string $userId, string $mobile, bool $toInvite, array $children)
    {
        $params = [
            'parent_userid' => $userId,
            'mobile' => $mobile,
            'to_invite' => $toInvite,
            'children' => $children
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/create_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除家长
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92332
     *
     * @param string $userId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteParent(string $userId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'userid' => $userId
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/delete_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 更新家长
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92333
     *
     * @param string $userId
     * @param string $mobile
     * @param string $newUserId
     * @param array $children
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateParent(string $userId, string $mobile, string $newUserId, array $children)
    {
        $params = [
            'parent_userid' => $userId
        ];
        if (!empty($newUserId)) {
            $params['new_parent_userid'] = $newUserId;
        }
        if (!empty($mobile)) {
            $params['mobile'] = $mobile;
        }
        if (!empty($children)) {
            $params['children'] = $children;
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/update_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 批量创建家长 每次最多100个
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92334
     *
     * @param array $parents [['parent_userid':'','mobile':'','to_invite':true,'children':['student_userid':'','relation':'']],.....]
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchCreateParents(array $parents)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'parents' => $parents
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_create_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量删除家长，每次最多100个
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92335
     *
     * @param array $userIdList 格式：['chang','lisi']
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchDeleteParents(array $userIdList)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'useridlist' => $userIdList
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_delete_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量更新家长，每次最多100个
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92336
     *
     * @param array $parents 格式：[['parent_userid':'','new_parent_userid':'','mobile':'','children':[['student_userid':'','relation':''],...]],.....]
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchUpdateParents(array $parents)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'parents' => $parents
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/user/batch_update_parent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 读取学生或家长
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92337
     *
     * @param string $userId 学生或家长的userid
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUser(string $userId)
    {
        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/user/get',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取部门成员详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92338
     *
     * @param int $departmentId
     * @param bool $fetchChild
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getStudents(int $departmentId, bool $fetchChild)
    {
        $params = [
            'department_id' => $departmentId
        ];
        if ($fetchChild) {
            $params['fetch_child'] = 1;
        } else {
            $params['fetch_child'] = 0;
        }

        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/user/list',
                $params
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取学校通知二维码
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/92197
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getSubscribeQrCode()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_subscribe_qr_code',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 设置关注「学校通知」的模式
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/92290#设置关注「学校通知」的模式
     *
     * @param int $mode 关注模式，1可扫码填写资料加入，2禁止扫码填写资料加入
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setSubscribeMode(int $mode)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'subscribe_mode' => $mode
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/set_subscribe_mode',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取关注「学校通知」的模式
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/92290#获取关注「学校通知」的模式
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getSubscribeMode()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_subscribe_mode',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 设置「老师可查看班级」的模式
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/92652#设置「老师可查看班级」的模式
     *
     * @param int $mode
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setTeacherViewMode(int $mode)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'view_mode' => $mode
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/school/set_teacher_view_mode',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取「老师可查看班级」的模式
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/92652#获取「老师可查看班级」的模式
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTeacherViewMode()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/school/get_teacher_view_mode',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 过滤数组中值为NULL的键
     * @param array $data
     * @return array
     */
    protected function filterNullValue(array $data)
    {
        $returnData = [];
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $returnData[$key] = trim($value);
            }
        }

        return $returnData;
    }
}
