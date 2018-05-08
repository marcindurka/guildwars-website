<?php
class content extends Controller{
	protected function index(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->index(), true);
	}
        protected function news(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->news(), true);
        }
        protected function recruitment(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->recruitment(), true);
        }
        protected function history(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->history(), true);
        }
        protected function recomended(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->recomended(), true);
        }
        protected function contact(){
            $viewmodel = new ContentModel();
            $this->returnView($viewmodel->contact(), true);
        }

}