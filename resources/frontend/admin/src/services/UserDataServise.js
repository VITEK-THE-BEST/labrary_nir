import http from "../http-common";

export default new class {
    registration(user) {
        return http.post("api/registration", {
            'name': user.name,
            'surname': user.surname,
            'patronymic': user.patronymic,
            'address': user.address,
            'phone': user.phone,
            'password': user.password,
        }, {
            'Accept': 'application/json',
        });
    }

    me(data) {
        return http.get("api/user/me", {
            headers: {
                'Authorization': "Bearer " + data.token,
                'Accept': 'application/json'
            },
        });
    }

    getToken(data) {
        return http.post("api/getToken", {
            'phone': data.phone,
            'password': data.password,
        }, {
            headers: {
                'Authorization': "Bearer " + data.token,
                'Accept': 'application/json'
            },
        });
    }

    dropToken(data) {
        return http.delete("api/user/dropToken", {
            headers: {
                'Authorization': "Bearer " + data.token,
                'Accept': 'application/json'
            },
        });
    }
    getUsers(token) {
        return http.get("api/admin/user/showAllUsers", {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }
};
