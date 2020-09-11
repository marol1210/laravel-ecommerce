import Vue from 'vue'

import 'normalize.css/normalize.css' // A modern alternative to CSS resets

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
//import locale from 'element-ui/lib/locale/lang/en' // lang i18n

import '@/styles/index.scss' // global css

import App from './App'
import store from './store'
import router from './router'

import '@/icons' // icon
import '@/permission' // permission control


/**
 * If you don't want to use mock-server
 * you want to use MockJs for mock api
 * you can execute: mockXHR()
 *
 * Currently MockJs will be used in the production environment,
 * please remove it before going online ! ! !
 */
 /*
if (process.env.NODE_ENV === 'production') {
  const { mockXHR } = require('../mock')
  mockXHR()
}
*/

// set ElementUI lang to EN
//Vue.use(ElementUI, { locale })
// 如果想要中文版 element-ui，按如下方式声明
Vue.use(ElementUI)

Vue.config.productionTip = false


/* Layout */
import Layout from '@/layout'


var customer_route = [
	{
		path: '/',
		component: Layout,
		redirect: '/dashboard',
		children: [
			{
				path: 'dashboard',
				name: 'Dashboard',
				component: () => import('@/views/dashboard/index'),
				meta: { title: 'Dashboard', icon: 'dashboard' }
			}
		]
	},
	  {
	    path: '/login',
	    component: () => import('@/views/login/index'),
	    hidden: true
	  },

	  {
	    path: '/404',
	    component: () => import('@/views/404'),
	    hidden: true
	  },
	{
		path: '/product-manage',
		component: Layout,
		meta: { title: '商品管理', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'product',
				name: 'product',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '商品'}
			},
			{
				path: 'category',
				name: 'category',
				component: () => import('@/views/wechat/material/list'),
				meta: { title: '商品类别'}
			},

			{
				path: 'property',
				name: 'property',
				component: () => import('@/views/wechat/autoreplay/index'),
				meta: { title: '商城商品属性'}
			},

			{
				path: 'attribute',
				name: 'attribute',
				component: () => import('@/views/wechat/autoreplay/index'),
				meta: { title: '商品属性'}
			}
		]
	},	
	{
		path: '/site-manage',
		component: Layout,
		meta: { title: '网站设置', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'product',
				name: 'product',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '网页菜单'}
			},
			{
				path: 'category',
				name: 'category',
				component: () => import('@/views/wechat/material/list'),
				meta: { title: '网页组件'}
			}
		]
	},
	{
		path: '/order-manage',
		component: Layout,
		meta: { title: '订单管理', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'product',
				name: 'product',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '订单列表'}
			},
			{
				path: 'category',
				name: 'category',
				component: () => import('@/views/wechat/material/list'),
				meta: { title: '订单设置'}
			}
		]
	},
	{
		path: '/user-manage',
		component: Layout,
		meta: { title: '用户管理', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'admin',
				name: 'admin',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '用户'}
			},
			{
				path: 'category',
				name: 'category',
				component: () => import('@/views/wechat/material/list'),
				meta: { title: '用户组'}
			}
		]
	},
	{
		path: '/cuxiao-manage',
		component: Layout,
		alwaysShow: true,
		meta: { title: '促销/活动', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'y_code',
				name: 'y_code',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '优惠码'}
			}
		]
	},
	{
		path: '/system-manage',
		component: Layout,
		meta: { title: '系统管理', icon: 'el-icon-s-shop' },
		children: [
			{
				path: 'system',
				name: 'system',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '系统配置'}
			},
			{
				path: 'currenty',
				name: 'currenty',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '货币'}
			},
			{
				path: 'role',
				name: 'role',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '角色'}
			}
		]
	},
	{
		path: '/wechat-manage',
		component: Layout,
		rediect:'keyword',
		meta: { title: '微信设置', icon: 'dashboard' },
		children: [
			{
				path: 'keyword',
				name: 'keyword',
				component: () => import('@/views/wechat/keyword/list'),
				meta: { title: '关键字管理', icon: 'dashboard' }
			},
			{
				path: 'material',
				name: 'material',
				component: () => import('@/views/wechat/material/list'),
				meta: { title: '素材管理', icon: 'dashboard' }
			},
			{
				path: 'autoreplay',
				name: 'autoreplay',
				component: () => import('@/views/wechat/autoreplay/index'),
				meta: { title: '自动回复', icon: 'dashboard' }
			}
		]
	}
];

customer_route.forEach((e)=>{
	router.options.routes.push(e);
});

router.addRoutes(  
	customer_route
);

//Vue.prototype.$http = require('./utils/crequest');

new Vue({
  el: '#app',
  router,
  store,
  render: h => h(App)
})
