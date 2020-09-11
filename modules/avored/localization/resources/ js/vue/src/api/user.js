import request from '@/utils/request'


const tokens = {
  admin: {
    token: 'admin-token'
  },
  editor: {
    token: 'editor-token'
  }
}

const users = {
  'admin-token': {
    roles: ['admin'],
    introduction: 'I am a super administrator',
    avatar: 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
    name: 'Super Admin'
  },
  'editor-token': {
    roles: ['editor'],
    introduction: 'I am an editor',
    avatar: 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
    name: 'Normal Editor'
  }
}

export function login(data) {

  const { username } =  {username:'admin'}
  const token = tokens[username]

/*
  return {
    code: 20000,
    data: token,
    status: 200,
  }
*/
return new Promise((a,b) => {

 a(
  {
    code: 20000,
    data: token,
    status: 200,
  }
);

});

  return request({
    url: '/vue-admin-template/user/login',
    method: 'post',
    data
  })
}

export function getInfo(t) {

      const { token } =  {token:'admin-token'}
      const info = users[token]


return new Promise((a,b) => {

 a(
  {
        code: 20000,
        data: info
  }
);
});




  return request({
    url: '/vue-admin-template/user/info',
    method: 'get',
    params: { t }
  })
}

export function logout() {
  return request({
    url: '/vue-admin-template/user/logout',
    method: 'post'
  })
}
