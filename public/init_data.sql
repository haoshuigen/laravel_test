--
-- 数据库： `laraveltest`
--

use laraveltest

--
-- 转存表中的数据 `test_system_admin`
--
INSERT INTO `test_system_admin` (`id`, `auth_ids`, `head_img`, `username`, `password`, `phone`, `remark`, `login_num`, `sort`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (NULL, '1', '/static/admin/images/head.jpg', 'admin', 'b23b0c3a53c8ead2dcea92cade3cbd797a4f3c04', 'admin', 'admin', '8', '0', '1', '1730870418', '1730870418', NULL);
INSERT INTO `test_system_admin` (`id`, `auth_ids`, `head_img`, `username`, `password`, `phone`, `remark`, `login_num`, `sort`, `status`, `create_time`, `update_time`, `delete_time`) VALUES (NULL, '2', '/static/admin/images/head.jpg', 'user1', 'b23b0c3a53c8ead2dcea92cade3cbd797a4f3c04', '13811111111', 'DDAAA', '2', '0', '1', '1730870418', '1730870418', NULL);


--
-- 转存表中的数据 `test_system_menu`
--
INSERT INTO `test_system_menu` (`id`, `pid`, `title`, `icon`, `href`, `params`, `target`, `sort`, `status`, `remark`, `create_time`, `update_time`, `delete_time`) VALUES
(1, 99999999, '后台首页', 'fa fa-home', 'index/welcome', '', '_self', 0, 1, '', 1730877078, 1730877078, NULL),
(2, 0, '系统管理', 'fa fa-cog', '', '', '_self', 0, 1, '', 1730877078, 1730877078, NULL),
(3, 2, '数据管理', 'fa fa fa-shower', 'system.dev/index', '', '_self', 0, 1, '', 1730877078, 1730877078, NULL);


--
-- 转存表中的数据 `test_system_auth`
--
INSERT INTO `test_system_auth` (`id`, `title`, `sort`, `status`, `remark`, `create_time`, `update_time`, `delete_time`) VALUES
(1, '管理员', 1, 1, '测试管理员', 1730877078, 1730877078, NULL),
(2, '普通用户', 0, 1, '普通用户', 1730877078, 1730877078, NULL);



--
-- 转存表中的数据 `test_system_node`
--

INSERT INTO `test_system_node` (`id`, `node`, `title`, `type`, `is_auth`, `create_time`, `update_time`) VALUES
(1, 'system.dev', '数据管理', 1, 1, 1730877078, 1730877078),
(2, 'system.dev/index', 'SQL查询', 2, 1, 1730877078, 1730877078);