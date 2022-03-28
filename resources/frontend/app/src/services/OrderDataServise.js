import http from "../http-common";

export default new class {
    create(data,token) {
        return http.get("api/order/create/" + data.id, {
            headers: {
                'Authorization': "Bearer " + token,
                'Accept': 'application/json'
            },
        });
    }
};
