import http from "../http-common";

export default new  class  {
    show(){
        return http.get("api/book/show");
    }
};
