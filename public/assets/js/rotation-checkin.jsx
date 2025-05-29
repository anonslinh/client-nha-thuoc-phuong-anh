
const { useState, useEffect, useRef, useContext } = React

// API endpoints
const baseUrl = window.location.origin + '/';

const API = {
    exchangeGift: () => baseUrl + "api/rotation-checkin/exchange-gift",
    getBranch: () => baseUrl + "api/branches",
    listGiftCheckRotationCheck: ()=>baseUrl+'api/rotation-checkin/list-gift',
    interface: () => baseUrl + "api/rotation-checkin/setting",
    register : () => baseUrl + "api/rotation-checkin/register",
    spin: () => baseUrl + "api/rotation-checkin/spin"
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

// Component App
function App() {

    const [phoneUser,setPhoneUser]=useState(localStorage.getItem("phone_user"));
    const [showLogin,setShowLogin]=useState(false);
    const [messageAlert, setMessageAlert] = useState("")
    const [countSpin, setCountSpin] = useState(0)
    const refModalShowGift = useRef(null)
    const refModalAlert = useRef(null)
    const [currentRotate, setCurrentRotate] = useState(0)
    const [isRotating, setIsRotating] = useState(false)
    const [currentGift, setCurrentGift] = useState(null)
    const [loading, setLoading] = useState(false)
    const refT = useRef("")
    const [listGift, setListGift] = useState([])
    const size = listGift.length
    const rotate = 360 / size
    const skewY = 90 - rotate
    const timeRotate = 7000
    const [showModalGift,setShowModalGift]=React.useState(false)
    const [listBranch, setListBranch] = React.useState([])
    const [branch_id,setBranchId]=React.useState('');
    const [imageCheckin, setImageCheckin] = React.useState(null);
    const [selectedFile, setSelectedFile] = React.useState(null);
    const [showModalAlert, setShowModalAlert] = useState(false)
    const [logo, setLogo] = React.useState('assets/static/logo.png');
    const [background, setBackground] = React.useState('assets/static/background.png');
    const [rotationImage, setRotationImage] = React.useState('assets/static/backgroundSpinner.png');
    const [colorButton, setColorButton] = React.useState('#FF4D5C');
    const [colorGift, setColorGift] = React.useState('#eb5757');

    const fileCheckinInputRef = React.useRef(null);


    const rotateWheel = (currentRotate, index) => {
        refT.current = `rotate(${currentRotate - index * rotate - rotate / 2}deg)`
    }

    const getInterface = async () => {
        const res = await REQUEST_API({
                url: API.interface(),
                method: "get",
                data: null
            })
            if(res.status){                
                if(res.data.logo){
                    setLogo(res.data.logo);
                }
                if(res.data.rotation){
                    setRotationImage(res.data.rotation);
                }
                if(res.data.background){
                    setBackground(res.data.background)
                }
                if(res.data.color_button){
                    setColorButton(res.data.color_button);
                }
                if(res.data.color_gift){
                    setColorGift(res.data.color_gift);
                }
        }
    }

    const getListGiftCheckin = async () => {
        var formData = new FormData();
        formData.append('phone', phoneUser);
        const res = await REQUEST_API({
            url: API.listGiftCheckRotationCheck(),
            method: "post",
            data: formData
        })
        if(res.status){
            setListGift(res.data);                
        }
    }
    useEffect(()=>{
        getListBranch()
        getInterface()
        getListGiftCheckin()
    },[]);

    const getListBranch = async  () =>{
        try {
            const res = await REQUEST_API({
                url: API.getBranch(),
                method: "get",
            })
            if(res.status){
                setListBranch(res.data);
            }
        }catch (e) {
            console.log(e)
        }finally {
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
        if(!phoneUser){
            setShowLogin(true);
            return false;
        }
        if (!isRotating){
            setIsRotating(true)
            var formData = new FormData();
            formData.append('phone', phoneUser);
            const res = await REQUEST_API({
                url: API.spin(),
                method: "post",
                data: formData
            });
            if(res.status){
                setListBranch(res.data);
                const gift = res.data;
                const newCurrentRotate = currentRotate + 360 * 10;
                rotateWheel(newCurrentRotate, gift.index);
                setCurrentRotate(newCurrentRotate);
                showGift(gift);
            }else{
                if (res?.login === true) {
                    setShowLogin(true);
                }else{
                    if(res?.data){
                        const gift = res.data;
                        const newCurrentRotate = currentRotate + 360 * 10;
                        rotateWheel(newCurrentRotate, gift.index);
                        setCurrentRotate(newCurrentRotate);
                        const timer = setTimeout(() => {
                            setIsRotating(false)
                            clearTimeout(timer)
                            setMessageAlert(res.msg);
                            setShowModalAlert(true);
                        }, timeRotate)
                    }else{
                        setIsRotating(false)
                        setMessageAlert(res.msg);
                        setShowModalAlert(true);
                    }
                }
            }
        }
    }
    const ModalAlert = () => {

        return (
            <div className="flex items-center w-full h-full bg-[#000000] bg-opacity-80 absolute top-0 left-0 z-[9999]">
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
                            {messageAlert}
                        </p>
                    </div>
                    <button
                        className="w-[70%] mx-auto py-1 flex items-center justify-center border-2 border-[#01B2FF] bg-blue mt-4 mb-6 rounded-md"
                        onClick={() => setShowModalAlert(false)}
                    >
                        <p className="text-base text-blue-500 font-light">Đóng</p>
                    </button>
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
                        <button className="flex items-center justify-center rounded-xl border px-5 py-2 border-blue-500 my-5 text-base text-black"
                        onClick={() => setShowModalGift(false)}>
                            ĐÓNG
                        </button>
                    </div>
                </div>
            </div>
        )
    }

    const login =async () => {
        try {
            const formData = new FormData()
            formData.append("phone", phoneUser)
            formData.append("branch_id", branch_id)
            formData.append("image", selectedFile)
            const res = await REQUEST_API({
                url: API.register(),
                method: "post",
                data: formData
            })
            if(res.status){
                localStorage.setItem("phone_user", phoneUser);
                setShowLogin(false)
                setCountSpin(1)
            }else{
                setMessageAlert(res.msg);
                setShowModalAlert(true);
            }
        } catch (error) {
            console.log(error)
        }
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
    return (
        <div className="main max-w-lg min-h-screen w-full m-auto" style={{ backgroundImage: `url(${background})`}}>
            <div className="py-4 flex flex-col items-center justify-center">
                {/* logo  */}
                <div className="mt-12">
                    <img
                        src={logo}
                        alt="logo"
                        style={{width: "200px"}}
                        className="w-64 h-auto object-cover"
                    />
                </div>
                {/* <span className="text-xl text-center text-white font-bold mx-auto">
                    Bạn có {countSpin} lượt quay
                </span> */}
                <div className="flex items-center justify-between w-full pt-2 relative">
                    <img
                        src={"assets/static/firework.png"}
                        alt="logo"
                        className="w-20 h-14 object-cover"
                    />
                    <img src={"assets/static/firework.png"} alt="logo" className="w-20 h-14 object-cover"/>
                </div>
                <div className="main-wheel" style={{ backgroundImage: `url(${rotationImage})`}}>
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
                                            backgroundColor: index % 2 == 0 ? colorGift : "#FFFFFF"
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
                        className="w-[90%] flex items-center justify-center rounded-[20px] mx-auto py-3" style={{backgroundColor: colorButton}}
                        onClick={() =>startSpin()}
                    >
                    <span className="text-base font-bold text-white uppercase">
                            Quay
                            </span>
                    </button>
                </div>
            </div>
            <ModalShowGift ref={refModalShowGift} currentGift={currentGift} />
            {showModalAlert&&<ModalAlert/>}
            {/*<ModalAlert />*/}
            <ModalShowGift/>
            {loading && <LoadingPage />}

            {
                showLogin && (
                    <div className={'fixed top-0 left-0 right-0 bottom-0 h-screen w-screen  z-50'}>
                        <div
                            className="relative main flex flex-col justify-center items-center h-full w-full "

                        >

                            <div className="px-2 w-full overflow-y-scroll ">

                                <div className="bg-white p-2 w-full rounded-md">
                                    <label  className="text-sm text-gray-60">Số điện thoại </label>
                                    <input type="text" id="first_name"
                                           onChange={(e)=>{
                                               setPhoneUser(e.target.value)
                                           }}
                                           className="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                           placeholder="Vui lòng nhập số điện   " />


                                    <div className="max-w-sm mx-auto mt-3">
                                        <label htmlFor="countries"
                                               className="block mb-2 text-sm font-medium ">Chọn chi nhánh </label>
                                        <select id="countries"
                                                onChange={(e)=>setBranchId(e.target.value)}
                                                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 ">

                                            <option selected>Chọn chi nhánh</option>

                                            {
                                                listBranch?.map((item,idx)=>(
                                                    <option key={idx} value={item.id}>{item.branch_name}</option>
                                                ))
                                            }


                                        </select>
                                    </div>

                                    <p  className="block mb-2 text-sm font-medium mt-2">Checkin</p>
                                    {imageCheckin && (
                                        <div className='mx-auto'>
                                            <div className="relative mx-auto">

                                                <img src={imageCheckin} alt="checkin" className='mx-auto w-full h-auto rounded-[8px]' />
                                                <div
                                                    onClick={()=>{
                                                        setImageCheckin(null);
                                                        setSelectedFile(null);
                                                    }}
                                                    className='absolute right-0 top-0 w-5 h-5 flex items-center justify-center rounded-full bg-[#626262] z-[999]'
                                                >
                                                    <span className="text-[12px] text-white font-inter">X</span>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {!imageCheckin&&(
                                        <div
                                            onClick={()=>{
                                                fileCheckinInputRef.current.click(); //
                                            }}
                                            className="mx-auto mt-2 mb-2 border-[1px] border-[#F4BE42] rounded-[6px] w-fit px-6 py-1 flex items-center justify-center text-black text-[14px] font-inter"
                                        >
                                            Chọn ảnh
                                        </div>

                                    )}
                                    <input
                                        ref={fileCheckinInputRef}
                                        type="file" accept="image/*" style={{display:'none'}} onChange={(event)=>{
                                        const file = event.target.files[0];
                                        if (file) {
                                            setSelectedFile(file);
                                            setImageCheckin(URL.createObjectURL(file));
                                        }
                                    }} />




                                    <div className="mt-3">
                                        <button
                                            onClick={login}

                                            className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Đăng Ký
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

