
const { useState, useEffect, useRef, useContext } = React

// API endpoints
const baseUrl = window.location.origin + '/';

const API = {
    getMyGift: () => baseUrl + "api/rotation/get-my-gift",
    exchangeGift: () => baseUrl + "api/rotation/exchange-gift",
    getListGift:()=> baseUrl + "api/rotation/list-gift"
}

// Hàm gọi API với Axios
const REQUEST_API = async ({ url, method, data }) => {
    const headers = { "Content-Type": "multipart/form-data" }
    const config = { method, url, data, headers }
    try {
        const res = await axios(config)
        if (res.status === 200) {
            return res.data
        }
    } catch (e) {
        if (String(e).includes("Network Error")) {
            throw new Error("Không có internet")
        } else {
            throw new Error(e.message)
        }
    }
}
const queryParams = new URLSearchParams(window.location.search);

// Giả lập AppContext
const AppContext = React.createContext({
    phoneUser: queryParams.get("phone"),
})

// Component App
function App() {

    const [phoneUser,setPhoneUser]=useState("");
    const [showLogin,setShowLogin]=useState(true);
    const [showModelMyGift,setShowModelMyGift]=useState(false);
    const [messageAlert, setMessageAlert] = useState("")
    const [countSpin, setCountSpin] = useState(0)
    const refModalShowGift = useRef(null)
    const refModalShowListGift = useRef(null)
    const refModalAlert = useRef(null)
    const [currentRotate, setCurrentRotate] = useState(0)
    const [isRotating, setIsRotating] = useState(false)
    const [currentGift, setCurrentGift] = useState(null)
    const [loading, setLoading] = useState(false)
    const refT = useRef("")
    const [listGift, setListGift] = useState([])
    const [listMyGift, setListMyGift] = useState([])
    const size = listGift.length
    const rotate = 360 / size
    const skewY = 90 - rotate
    const timeRotate = 7000
    const [showModalGift,setShowModalGift]=React.useState(false)

    const rotateWheel = (currentRotate, index) => {
        refT.current = `rotate(${currentRotate - index * rotate - rotate / 2}deg)`
    }
    const queryParams = new URLSearchParams(window.location.search);
    useEffect(()=>{
        if(queryParams.get("phone")){
            setPhoneUser(queryParams.get("phone"))
            setShowLogin(false)
        }
    },[queryParams])

    const getGift = () => {
        const randomNumber = Math.random()
        let currentPercent = 0
        const list = []
        listGift.forEach((item, index) => {
            currentPercent += Number(item.percent)
            if (randomNumber <= currentPercent) {
                list.push({ ...item, index })
            }
        })
        return list[0]
    }


    const getListGift = async () => {
        try {
            const formData = new FormData()
            formData.append('phone', phoneUser)
            const res = await REQUEST_API({
                url: API.getListGift(),
                method: "post",
                data: formData
            })
            if(res.status){
                setListGift(res.data)
                setCountSpin(res.number_play)
                setShowModalGift(false)
            }
        } catch (error) {
            console.log(error)
        } finally {
            setLoading(false)
        }
    }



    const showGift = gift => {
        const timer = setTimeout(() => {
            setIsRotating(false)
            setCurrentGift(gift)
            refModalShowGift.current?.setShowModal(true)
            refModalShowGift.current?.setTest(10)
            setShowModalGift(true)
            clearTimeout(timer)
        }, timeRotate)
    }

    const startSpin = async () => {
        if (countSpin < 1) {
            setMessageAlert("Bạn đã hết lượt quay");
            refModalAlert.current?.setShowModal(true);
        } else if (!isRotating) {
        setIsRotating(true)
        const gift = getGift();
        const newCurrentRotate = currentRotate + 360 * 10;
        rotateWheel(newCurrentRotate, gift.index);
        setCurrentRotate(newCurrentRotate);
        try {
            const formData = new FormData()
            formData.append("phone", phoneUser)
            formData.append("gift_id", gift.id)
            const res = await REQUEST_API({
                url: API.exchangeGift(),
                method: "post",
                data: formData
            })
            if(res.status){
                showGift(gift)
            }else{
                const timer = setTimeout(() => {
                    alert(res.msg)
                    setIsRotating(false)
                    clearTimeout(timer)
                }, timeRotate)
            }
        } catch (error) {
            alert(error.msg)
        } finally {
            setLoading(false)
        }
        }
    }

    const getMyGift = async () => {
        try {
            setLoading(true)
            const formData = new FormData()
            formData.append("phone", phoneUser)
            const res = await REQUEST_API({
                url: API.getMyGift(),
                method: "post",
                data: formData
            })
            if (res.status) {
                setListMyGift(res.data)
                setShowModelMyGift(true)
            } else {
                alert(res.msg)
            }
        } catch (error) {
            alert(error.msg)
        } finally {
            setLoading(false)
        }
    }

    const postMyGift = async item => {
        try {
            setLoading(true)
            const formData = new FormData()
            formData.append("phone", phoneUser)
            formData.append("app_id", "your-app-id")
            formData.append("product_id", item.id.toString())
            const res = await REQUEST_API({
                url: API.getMyGift(),
                method: "post",
                data: formData
            })
            if (!res.status && res.msg?.includes("Chưa follow OA")) {
                setIsFollowOA(false)
            } else if (res.status) {
                setListMyGift(res.response)
            } else {
                alert(res.msg)
            }
        } catch (error) {
            console.log(error)
        } finally {
            setLoading(false)
        }
    }


    const ModalShowListGift = React.forwardRef((props, ref) => {
        const [showModal, setShowModal] = useState(false)

        React.useImperativeHandle(ref, () => ({
            setShowModal
        }))

        const { data } = props

        if (!showModal) return null

        return (
            <div className="flex items-center w-full h-full bg-[#000000] bg-opacity-80 absolute top-0 left-0 z-50">
            <div className="flex flex-col w-[90%] h-[70%] m-auto bg-white rounded-lg overflow-hidden">
            <div className="flex items-center border-b-4 pb-2 pt-1 border-b-slate-100">
            <div className="flex-1 items-center justify-center">
            <p className="text-base text-[#eb5757] ml-10 uppercase text-center font-bold">
            DANH SÁCH QUÀ TẶNG
        </p>
        </div>
        <button className="w-10 h-10" onClick={() => setShowModal(false)}>
    <span className="w-4 h-4 m-auto">×</span>
        </button>
        </div>
        <div className="overflow-y-scroll no-scrollbar">
            {data &&
            data.length > 0 &&
            data.map((item, index) => (
                <div
        className="flex mb-2 pb-3 pt-1 mt-1"
        key={index}
        style={{
            borderBottomWidth: index !== data.length - 1 ? 2 : 0,
                borderBottomColor:
            index !== data.length - 1 ? "#62626250" : "none"
        }}
    >
    <img
        src={
            item.image ? `${baseUrl}${item.image}` : "./gift-icon.png"
        }
        className="w-20 h-20 ml-2 object-cover rounded-lg flex-shrink-0"
        alt="Gift"
            />
            <p className="ml-2 mr-2 text-xs text-black font-medium">
            {item.title}
            </p>
            </div>
    ))}
    </div>
        </div>
        </div>
    )
    })

    const ModalAlert = React.forwardRef((props, ref) => {
        const [showModal, setShowModal] = useState(false)

        React.useImperativeHandle(ref, () => ({
            setShowModal
        }))

        const { messageShow } = props

        if (!showModal) return null

        return (
            <div className="flex items-center w-full h-full bg-[#000000] bg-opacity-80 absolute top-0 left-0 z-50">
            <div className="w-[70%] m-auto bg-white rounded-lg">
            <div className="flex items-center border-b-4 pb-2 pt-2 border-b-slate-100">
            <div className="flex-1 items-center justify-center">
            <p className="text-base text-blue-600 uppercase text-center">
            Thông báo
        </p>
        </div>
        </div>
        <div className="py-4">
            <p className="text-base text-[#504da4] text-center">
            {messageShow}
            </p>
            </div>
            <button
        className="w-[70%] mx-auto py-1 flex items-center justify-center border-2 border-[#01B2FF] bg-blue mt-4 mb-6 rounded-md"
        onClick={() => setShowModal(false)}
    >
    <p className="text-base text-blue-500 font-light">Đóng</p>
            </button>
            </div>
            </div>
    )
    })

    const ModalShowMyGift = (props, ref) => {

        const { data } = props

        if (!showModelMyGift) return null

        return (
            <div className="flex items-center w-full h-full bg-[#000000] bg-opacity-80 absolute top-0 left-0 z-50">
            <div className="flex flex-col w-[90%] h-[70%] m-auto bg-white rounded-lg overflow-hidden">
            <div className="flex items-center border-b-4 pb-2 pt-1 border-b-slate-100">
            <div className="flex-1 items-center justify-center">
            <p className="text-base text-[#eb5757] ml-10 uppercase text-center font-bold">
            DANH SÁCH QUÀ TẶNG CỦA TÔI
        </p>
        </div>
        <button className="w-10 h-10" onClick={() => setShowModelMyGift(false)}>
    <span className="w-4 h-4 m-auto">×</span>
        </button>
        </div>
        <div className="overflow-y-scroll no-scrollbar">
            {( data?.length === 0) && (
            <p className="font-medium text-red-500 text-base ml-4 mt-2">
            Bạn chưa có quà tặng.
        </p>
    )}
        {!!data &&
        !!data.length > 0 &&
        data.map((item, index) => {
            return (
                <div
            key={index}
            className="flex flex-col mb-2 pb-3 pt-1 mt-1"
            style={{
                borderBottomWidth: data.length - 1 !== index ? 2 : 0,
                    borderBottomColor:
                data.length - 1 !== index ? "#62626250" : "none"
            }}
        >
        <div className="flex">
                <img
            src={
                item.image_gift
                    ? `${baseUrl}${item.image_gift}`
                    : "./gift-icon.png"
            }
            className="w-20 h-20 ml-2 object-cover rounded-lg flex-shrink-0"
            alt="Gift"
                />
                <p className="ml-2 mr-2 text-xs text-black font-medium">
                {item.name_gift}
                </p>
                </div>
            </div>
        )
        })}
    </div>
        </div>
        </div>
    )
    }

    const ModalShowGift =(props, ref) => {
            if(!showModalGift) return  null
        return (
            <div className="flex items-center w-full h-full bg-[#000000] bg-opacity-80 absolute top-0 left-0 z-50">
                <div className="w-[90%] m-auto bg-white rounded-lg">
                    <div className="flex flex-col items-center pb-2 pt-1">
                        <div className="flex-1 items-center justify-center">
                            <p className="text-base my-4 text-[#eb5757] uppercase text-center">
                                Chúc mừng bạn đã nhận được
                            </p>
                        </div>
                        <div className="flex items-center justify-center flex-col px-4 text-center">
                            <img
                                src={
                                    currentGift && currentGift.image
                                        ? `${baseUrl}` + currentGift.image
                                        : "./gift-icon.png"
                                }
                                className="min-w-[70px] max-w-[100px] h-auto rounded-lg mb-5"
                                alt="Gift"
                            />
                            <p className="text-sm text-black font-medium">
                                {currentGift && currentGift.title
                                    ? currentGift.title
                                    : "Phần thưởng"}
                            </p>
                        </div>
                        <button
                            className="flex items-center justify-center rounded-xl border px-5 py-2 border-blue-500 my-5 text-base text-black"
                            onClick={() => getListGift()}
                        >
                            ĐÓNG
                        </button>
                    </div>
                </div>
            </div>
        )
    }

    const login = () => {
        if (!phoneUser || !/^\d{10}$/.test(phoneUser)) {
            alert("Số điện thoại không hợp lệ! Vui lòng nhập đúng 10 chữ số.");
            return;
        }

        setShowLogin(true);
        window.location.href = window.location.origin + "/play-rotation?phone=" + phoneUser;
    };


    const LoadingPage = () => <div>Đang tải...</div>

    const checkPercent =(length)=>{
        if(!length) return '80';
        if(length<6){
            return  '80'
        }
        if(length>=6&&length<9){
            return  '75'
        }
        if(length>=9&&length<12){
            return  '65'
        }
        if(length>=12&&length<16){
            return  '50'
        }
        if(length>=16){
            return  '40'
        }
    }

    useEffect(()=>{
        getListGift()
    },[phoneUser])

    console.log(listGift?.length)

    return (
        <div className="main max-w-lg min-h-screen w-full m-auto">
        <div className="py-4 flex flex-col items-center justify-center">
        {/* logo  */}
        <div className="mt-12">
        <img
    src={"assets/static/logo.png"}
    alt="logo"
    style={{width: "100px"}}
    className="w-64 h-auto object-cover"
        />
        </div>
        <div className="flex items-center justify-between w-full pt-2 relative">
        <img
    src={"assets/static/firework.png"}
    alt="logo"
    className="w-20 h-14 object-cover"
        />
        <span className="text-xl text-center text-white font-bold mx-auto">
        Bạn có {countSpin} lượt quay
    </span>
        <img src={"assets/static/firework.png"} alt="logo" className="w-20 h-14 object-cover"/>
        </div>
            <div className="main-wheel">
                <ul className="wheel" style={{ transform: refT.current }}>
                    {!!listGift &&
                    !!listGift.length &&
                    listGift.map((item, index) => {
                        return (
                            <li
                                key={index}
                                className='border-li'
                                style={{
                                    transform: `rotate(${
                                        rotate * index
                                    }deg) skewY(-${skewY}deg)`,
                                }}
                            >
                                <div
                                    style={{
                                        transform: `skewY(${skewY}deg) rotate(${
                                            rotate / 2
                                        }deg)`,
                                    }}
                                    className={`${
                                        index % 2 == 0 ? "text-item even" : "text-item"
                                    }`}
                                >
                                    <div className="flex items-center justify-center mx-auto max-w-[20%] flex-col">
                                        <img
                                            // src="assets/static/iconGift.png"
                                            src={ `${baseUrl}` + item.image}
                                            className=" mt-[30%] ratio"
                                            style={{
                                                width:`${checkPercent(listGift.length)}%`
                                            }}
                                        />
                                    </div>
                                </div>
                            </li>
                        );
                    })}
                </ul>
                <div className="absolute z-20 top-[4%]">
                    <img src="assets/static/iconArrowDown.PNG" className="w-8 h-8" />
                </div>
            </div>

    {/* bóng và hộp quà  */}
<div className="w-full flex items-center justify-center pt-12 relative">
        <img
    src={"assets/static/giftLeft.png"}
    className="w-7 h-auto object-cover absolute left-0 -top-7 z-10"
        />
        <img
    src={"assets/static/giftRight.png"}
    className="w-5 h-auto object-contain absolute right-0 -top-14 z-10"
        />
        <img
    src={"assets/static/shadow.png"}
    className="w-[75%] h-auto object-cover absolute bottom-0"
        />
        </div>
        <div className="w-full flex flex-col items-center mt-6 justify-center">
        <button
    className="bg-[#FF4D5C] w-[90%] flex items-center justify-center rounded-[20px] mx-auto py-3"
    onClick={() =>startSpin()}
>
<span className="text-base font-bold text-white uppercase">
        Quay
        </span>
        </button>
        <div className="grid grid-cols-2 w-[90%] gap-x-2">
        <button
    className="bg-[#FF4D5C] flex items-center justify-center rounded-[20px] mt-4 py-3"
    onClick={() => getMyGift()}
>
<span className="text-sm font-bold text-white uppercase">
        Xem quà của tôi
    </span>
    </button>
    <button
    className="bg-[#FF4D5C] flex items-center justify-center rounded-[20px] mt-4 py-3"
    onClick={() => refModalShowListGift.current?.setShowModal(true)}
>
<span className="text-sm font-bold text-white uppercase">
        Xem danh sách quà
    </span>
    </button>
    </div>
    </div>
    </div>
    <ModalShowGift ref={refModalShowGift} currentGift={currentGift} />
    <ModalShowListGift ref={refModalShowListGift} data={listGift} />
    <ModalAlert ref={refModalAlert} messageShow={messageAlert} />
        <ModalShowMyGift
        data={listMyGift}
        />

        <ModalShowGift/>
            {loading && <LoadingPage />}

            {
                showLogin && (
                    <div className={'fixed top-0 left-0 right-0 bottom-0 h-screen w-screen  z-50'}>
                        <div
                            className="relative main flex flex-col justify-center items-center h-full w-full "

                        >

                        <div className="px-2 w-full ">
                            <div className="absolute top-20  w-full flex justify-center ">
                                <img
                                    src={"assets/static/logo.png"}
                                    alt="logo"
                                    className="w-64 h-auto object-cover"
                                />
                            </div>
                                <div className="bg-white p-2 w-full rounded-md">

                                    <label  className="text-sm text-gray-60">Số điện thoại </label>
                                    <input type="text" id="first_name"
                                           onChange={(e)=>{
                                               setPhoneUser(e.target.value)
                                           }}
                                           className="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                           placeholder="Vui lòng nhập số điện   " />

                                    <div className="mt-3">
                                        <button
                                            onClick={login}

                                                className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Đăng Nhập
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                )
            }

    </div>
    )
}

// AppProvider
const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(<App />);

